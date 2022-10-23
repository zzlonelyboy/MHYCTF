<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\DB;
use App\Models\theuser\PublicUser;
class PublicUserController extends Controller
{
//    此处自动检测
    public function check(Request $request){
        if($request->isMethod('post'))
        {
            $request->validate([
                'username'=>'required|max:20|unique:users,username|alpha_num',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:8',
            ]);
        }
    }
    //此处进行注册操作
    public function signup(Request $request){
        $this->check($request);
        $freshuser= new publicuser();
        $freshuser->username=$request->username;
        $freshuser->password=bcrypt($request->passwd);
        $freshuser->email=$request->email;
        $freshuser->save();
        return redirect('public/login');
    }
    //登陆
    public function login(Request $request){
        if($request->isMethod('POST'))
        {
            $request->validate([
                'username'=>'required|max:20|alpha_num',
                'password'=>'required|max:20',
                'captcha'=>'required|size:5|captcha',
            ]);
            $data=$request->only(['username','password']);
            $remember=$request->post('remermber');
//            $result=Auth::guard('public_user')->attempt($data,$remember);
            $result=Auth::guard('public_user')->attempt($data,false);
//            echo $result;
            if($result){
             return redirect('public/index');
            }
            else{
                return redirect('public/login')->withErrors(
                    ['loginerror'=> '用户名或密码错误',]
                );
            }
        }
    }
    //检测是否登陆
    public function checklogon(){
        if(Auth::check())
        {
            return redirect('public/index');
        }
        else{
            return redirect('public/login');
        }
    }
    //reset the passwd
    public function reset(){

    }
    //logout
    public function logout(){
        Auth::logout();
        return redirect('public/login');
    }
}
