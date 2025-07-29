<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; 
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request){
        
        

        $query = Order::query()->with('items')->where('isDelete',0);
        if($request->filled('phone')){
            $query->where('phone',$request->phone);
        }
        if($request->filled('receiver_Name')){
            $query->where('receiver_Name','like','%'.$request->receiver_Name.'%');
        }
        if($request->filled('start_date') && $request->filled('end_date')){
            $query->whereBetween('created_at',[$request->start_date,$request->end_date]);
        }elseif($request->filled('start_date')){
            $query->where('created_at','>=',$request->start_date);
        }elseif($request->filled('end_date')){
            $query->where('created_at','<=',$request->end_date);
        }
        if($request->filled('sort_by') && $request->filled('sort_order')){
            $sortBy= $request->sort_by;
            $sortOrder = $request->sort_order;

            $allowedSortBy = ['total_price'];
            if(in_array($sortBy,$allowedSortBy) && in_array(strtolower($sortOrder),['asc','desc'])){
                $query->orderBy($sortBy,$sortOrder);
            }
        }
         
        $limit = $request->input('limit',10);
        $orders = $query->paginate($limit);
         $orders ->appends($request->query());
        // return response()->json($orders);
        return view ('orders.index',compact('orders'));
       
    }

    public function show($id){
         $order = Order::with(
            'items.product.category',
            'user','province','district','ward'
         )->findOrFail($id);
        
        // return response()->json($orders);
        return view('orders.show',compact('order'));
    }

    public function store(Request $request){
        $user= JWTAuth::parseToken()->authenticate();
        $validateData = $request ->validate([

            'receiver_Name'=>'required|string|max:255',
            'phone'=>'required|string|digits_between:9,10',
            'province_code'=>'required|string|exists:provinces,code',
            'district_code'=>'required|string|exists:districts,code',
            'ward_code'=>'required|string|exists:wards,code',
            'detail_address'=>'required|string|max:255',

            'items'=>'required|array|min:1',
            'items.*.product_id'=>'required|integer|exists:products,id',
            'items.*.quantity'=>'required|integer|min:1'
        ]);

        $orders = Order::create([
            'receiver_Name'=>$validateData['receiver_Name'],
            'phone'=>$validateData['phone'],
            'province_code'=>$validateData['province_code'],
            'district_code'=>$validateData['district_code'],
            'ward_code'=>$validateData['ward_code'],
            'detail_address'=>$validateData['detail_address'],
            'user_id'=>$user->id
        ]);
        foreach($validateData['items'] as $item){
            $orders->items()->create([
                'product_id'=>$item['product_id'],
                'quantity'=>$item['quantity'],
            ]);

        }
        $orders->load('items');
        return response()->json([
            'message'=>'Tạo đơn hàng thành công',
            'order'=>[
                'id' => $orders->id,
                'receiver_Name' => $orders->receiver_Name,
                'phone' => $orders->phone,
                'province_code' => $orders->province_code,
                'district_code' => $orders->district_code,
                'ward_code' => $orders->ward_code,
                'detail_address' => $orders->detail_address,
                'user_id' => $orders->user_id,
                'items' => $orders->items->map(function ($items) {
                    return [
                        'product_id' => $items->product_id,
                        'quantity' => $items->quantity,
                    ];
                })
            ]
        ]);

    }

    public function destroy($id){
        $order = Order::findOrFail($id);
        $order -> isDelete = 1;
        $order -> save();
        return redirect()->route('orders.index')->with('success','Xóa đơn hàng thành công');
    }

    public function export(){
        return Excel::download(new OrdersExport,'orders.xlsx');
    }
}
