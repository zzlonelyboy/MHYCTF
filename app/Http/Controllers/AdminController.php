<?php

namespace App\Http\Controllers;

use App\Models\Team\TeamModel;
use App\Models\theuser\PublicUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //检测
    public function check(Request $request){
        if($request->isMethod('post'))
        {
            $request->validate([
                'username'=>'required|max:20|unique:admin,username|alpha_num',
                'email'=>'required|email|unique:admin,email',
                'passwd'=>'required|min:8|prohibited:select,show,\',\",update,rename,(,),#,',
            ]);
        }
    }

    public function login(Request $request){
        if($request->isMethod('POST'))
        {
            $request->validate([
                'username'=>'required|max:20|alpha_num',
                'password'=>'required|max:20',
                'captcha'=>'required|size:5|captcha',
            ]);
            $data=$request->only(['username','password']);
//            $result=Auth::guard('public_user')->attempt($data,$remember);
            $result=Auth::guard('admin_user')->attempt($data,false);
//            echo $result;
            if($result){
                return redirect('/admin/index')->with($data);
            }
            else{
                return redirect('/admin/page/login')->withErrors(
                    ['loginerror'=> '用户名或密码错误',]
                );
//                return "error";
            }
        }
    }
    public function logout(){
        Auth::guard('admin_user')->logout();
        return redirect('admin/page/login');
    }
    public function userchange(Request $request){
        $theuser=PublicUser::where('username',$request->username)->first();
        var_dump($request->username);
        if($theuser->team=='null'){
            PublicUser::where('username',$request->username)->delete();
            return redirect('/admin/index');
        }
        else{
            $team=TeamModel::where('teamname',$theuser->team)->first();
            $teammate=$team->teammate;
            $teammate=unserialize($teammate);
            $teammate=array_diff($teammate,[$theuser->username]);
            $teammate=array_values($teammate);
            $teammate=serialize($teammate);
            $team->teammate=$teammate;
            $team->save();
            PublicUser::where('username',$request->username)->delete();
            return redirect('/admin/index');
        }
    }
    public function teamchange(Request $request){
            $team=TeamModel::where('teamname',$request->teamname)->first();
            $teammates=unserialize($team->teammate);
            foreach($teammates as $teammate){
                $user=PublicUser::where('username',$teammate)->first();
                $user->team='null';
                $user->save();
        }
        TeamModel::where('teamname',$request->teamname)->delete();
            return redirect('/admin/index');
    }
}
