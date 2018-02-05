<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class UsersController extends Controller{

    public function __construct(){
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);
        $this->middleware('guest',[
            'only'=>'create'
        ]);
    }
    // 显示用户列表
    public function index(){
        // $users = User::all();
        $users = User::paginate(10);
        return view('users.index',compact('users'));
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

        // 用户注册后自动登陆
        Auth::login($user);

        // 闪存
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
        // 与下面这句等同
        // return redirect()->route('users.show',[$user->id]);
    }

    // 编辑用户信息页面
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    // 更新用户
    public function update(User $user,Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update',$user);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','您好，更改个人信息成功');
        return redirect()->route('users.show',$user->id);
    }

    // 删除用户
    public function destroy(User $user){
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功删除用户');
        return back();
        // return redirect()->back();

    }

}
