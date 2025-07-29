<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth; 
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index(Request $request){
        try{
            $query = Product::with('category');
           
            if($request->filled('category.category_name')){
                $query->whereHas('category',function ($q) use ($request){
                    $q->where('name','like','%'.$request->category_name.'%');
                });
            }
            if($request->has('name_product')){
                $query -> where('name_product','like','%'.$request->name_product.'%');
            }
            if($request->has('min_price')){
                 $query->where('price','>=',$request->min_price);
            }
            if($request->has('max_price')){
                $query->where('price','<=',$request->max_price);
            }
            if($request->has('min_price') && $request->has('max_price')){
                $query->whereBetween('price',[$request->min_price,$request->max_price]);
            }
        
           
            $products = $query->paginate(10);
            
            return response()->json(['status'=>'success','data'=>$products],200);
        } catch(\Exception $e){
            return response()->json(['status'=>'err','message'=>'Lỗi hệ thống'],500);            
        }
    }

    public function show($id){
        try{
        $product = Product::findOrFail($id);
        return response()->json(['status'=>'success','data'=>$product],200);
        }catch(ModelNotFoundException $e){
            return response()->json(['status'=>'err','message'=>'Không tìm thấy sản phẩm'],404);
        
        }catch(\Exception $e){
            return response()->json(['status'=>'err','message'=>'Lỗi hệ thống'],404);
        }
    }

    public function store(Request $request){
      
            $validatedData = $request->validate([
                'name_product' =>'required|string|max:255',
                'price' => 'required|numeric|gt:0|max:100000000',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stock' => 'required|integer|gt:0|max:200',
            ]);
            if($request->hasFile('image')){
                $imagePath= $request->file('image')->store('products','public');
                $validatedData['image']=$imagePath;
            }
            $product = Product::create($validatedData);
            $product -> image = asset('storage/' .$product->image);
            return response()->json(['status'=>'success','product'=>$product]);
       
    }

    public function update(Request $request,$id){
        $product = Product::findOrFail($id);
      
            $validatedData = $request->validate([
                'name_product' =>'sometimes|string|max:255',
                'price' => 'sometimes|numeric|gt:0|max:100000000',
                'category_id' => 'sometimes|exists:categories,id',
                'description' => 'sometimes|string|max:255',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stock' => 'sometimes|integer|gt:0|max:200',
            ]);
            $oldImage= $product->image;
       
        if($request->hasFile('image')){
            $newImage=$request->file('image')->store('products','public');
            $validatedData['image']=$newImage;
        }
        $product->update($validatedData);
        // $product->refresh();
        if(isset($newImage) && $oldImage && \Storage::disk('public')->exists($oldImage)){
            \Storage::disk('public')->delete($oldImage);
        }
       
        return response()->json([
            'status'=>'success',
            'message'=>'Cập nhật thành công',
            'product' =>$product
        ]);
        
    }

    public function destroy($id){
        $product = Product::destroy($id);
        return response()->json(['status'=>'success','message'=>'Xóa thành công']);
    }


    public function register(Request $request){
        $validatedData = $request->validate([
            'username'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'password'=>'required|string|max:255|min:8'
        ]);
        $user = User::create([
            'username'=>$validatedData['username'],
            'email'=>$validatedData['email'],
            'password'=>Hash::make($validatedData['password']),
            'role'=>'admin',
            'permission_level'=>'read',
        ]);
        return response()->json([
            'status'=>'success',
            'user'=>$user,
        ]);
    }
}
