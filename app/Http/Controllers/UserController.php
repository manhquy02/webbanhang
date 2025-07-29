<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'username' =>'nullable|string|max:255',
            'page'=>'nullable|integer|min:1',
            'limit'=>'nullable|integer|min:1'
        ]);
        $query = User::query();
        if($request->filled('username')){
            $query->where('username','like','%'.$request->username . '%');
        }
        // if($request->filled('page') && $request->filled('limit')){
        //     $limit = (int)$request->limit;
        //     $users = $query->paginate($limit);
        //     $users ->getCollection()->makeHidden('password');
        //     return view('users.index',compact('users'));
            // return response()->json([
            //     'user'=>$users->items(),
            //     'pagination'=>[
            //         'page'=>$users->currentPage(),
            //         'totalPage'=>$users->lastPage(),
            //         'totalItems'=>$users->total()
            //     ]
            //     ]);

        // }else{

        $limit = $request->input('limit',10);
        $users=$query->paginate($limit);
        $users->makeHidden('password');
        $users->appends($request->query());
        
        return view('users.index',compact('users'));
    }


    public function show($id){
        $users = User::find($id);
        if(!$users){
            return response()->json($users);
        }
        return response()->json($users);
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'username'=>'required|string|max:255',
            'email'=>'required|email',
            'password' =>'required|string|min:6'
        ]);
        $user = User::create($validateData);
        return response()->json([
            'message'=>'Tạo người dùng thành công',
            'user'=>$user
        ],200);

    
    }

    public function export(){
        return Excel::download(new UsersExport,'users.xlsx');
    }

    
} 
