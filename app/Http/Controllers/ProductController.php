<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; 
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;


use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request){
        // if(!Gate::allows('read-content')){
        //     abort(403,'gfdhgf');
        // }
        $query = Product::query()->with('category')->where('isDelete',0);
        if($request->filled('name_product')){
            $query->where('name_product','like','%'. $request->name_product . '%');
        }

        if($request->filled('category_id')&& $request->category_id != ''){
            $query->where('category_id', $request->category_id);
        }

        if($request->filled('min_price')&& $request->filled('max_price')){
            $query->whereBetween('price',[$request->min_price,$request->max_price]);
        }elseif($request->filled('min_price')){
            $query->where('price','>=', $request->min_price);
        }elseif($request->filled('max_price')){
            $query->where('price','<=',$request->max_price);
        }

        if($request->filled('sort_by') && $request->filled('sort_order')){
            $sortBy = $request->sort_by;
            $sortOrder =$request->sort_order;

            $allowedSortBy = ['price','name_product'];
            if(in_array($sortBy,$allowedSortBy)&&in_array(strtolower($sortOrder),['asc','desc'])){
                $query->orderBy($sortBy,$sortOrder);
            }
        }

        $limit = $request->input('limit',5);
        $products = $query->paginate($limit);
        $products->appends($request->query());
        $categories = Category::all();

    return view ('products.index',compact('products','categories'));
  
}



    public function show($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message'=>'Sản phẩm không tồn tại'],404);
        }
        return response()->json($product);
    }

    public function store(Request $request){
        if(!Gate::allows('edit-content')){
            abort(403, 'Cấm!!!!!!!!!!!!!!!!!!!!Cấm');
        }
        $validatedData = $request->validate([
        'name_product' => 'required|string|max:255',
        'price' => 'required|numeric|gt:0',
        'category_id' => 'required|integer|exists:categories,id',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        'stock' => 'required|integer|gt:0',
        ]);
        if($request -> hasFile('image')){
            $imageName= time().'.'.$request->image->extension();
            $request->image->storeAs('images',$imageName,'public');
            $validatedData['image']=$imageName;
        }
        $products = Product::create($validatedData);
        $products->image = asset('storage/images/'.$products->image);

        return redirect()->route('products.index')->with('success','Thêm sản phẩm thành công');
        // return response()->json([
        //     'message' => 'Tạo sản phẩm thành công',
        //     'product' => $product
        // ],200);
    }

    public function update(Request $request , $id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message'=>"Sản phẩm không tồn tại"],404);
        }
        $validatedData = $request->validate([
        'name_product' => 'required|string|max:255',
        'price' => 'required|numeric|gt:0',
        'category_id' => 'required|integer|exists:categories,id',
        'description' => 'required|string',
        'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif',
        'stock' => 'required|integer|gt:0',
        ]);
        if($request->hasFile('image')){
            if($product->image && \Storage::disk('public')->exists('images/'.$product->image)){
                \Storage::disk('public')->delete('images/'.$product->image);
            }
        
        $imageName = time().'.'.$request->image->extension();
       

        $request->image->storeAs('images',$imageName,'public');
        $validatedData['image']=$imageName;
        }

        $product -> update($validatedData);
        return redirect()->route('products.index')->with('success','Cập nhật thành công');
        // return response()->json([
        //     'message'=>'Cập nhật thành công',
        //     'product'=>$product
        // ],200);
    }

    // public function edit($id){
    //     $product = Product::FindOrFail($id);
    //     $categories = Category::all();
    //     return view('products.index',compact('product','categories'));
    // }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product -> isDelete = 1;
        $product -> save();
        // return response()->json(['message'=>'Xóa sản phẩm thành công'],200);
        return redirect()->route('products.index')->with('success','Xóa sản phẩm thành công');
    }

    public function export(){
        return Excel::download(new ProductsExport,'products.xlsx');
    }

}
