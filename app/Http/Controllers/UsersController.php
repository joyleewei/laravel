<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class UsersController extends Controller{
    // 显示用户列表
    public function index(){
        return view('users.index');
    }

    // 显示用户信息
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //创建用户页面
    public function create(){
        return view('users.create');
    }

    // 创建用户提交---POST
    public function store(Request $request){
        $this->validate($request,array(
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ));
        $user = User::create(array(
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ));
        Auth::login($user);
        // 闪存
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
        // 与下面这句等同
        // return redirect()->route('users.show',[$user->id]);
    }

    // 编辑用户信息页面
    public function edit(){

    }

    // 更新用户
    public function update(){

    }

    // 删除用户
    public function delete(){

    }

}
