<?php

namespace App\Http\Controllers;
use App\Models\Team\TeamModel;
use App\Models\theuser\PublicUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    //
    public function check(Request $request){
        if($request->isMethod('post'))
        {
            $request->validate([
                'teamname'=>'required|max:20|unique:team,teamname|alpha_num',
            ]);
        }
    }

    public function create(Request $request){

        if(!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $this->check($request);
//            取当前用户值
            $captain=PublicUser::where('username',Auth::user()->username)->first();
//            取当前用户的数据库对应
            if($captain->team!='null')
            {
                return redirect('/public/ucenter')->withErrors("you can not create a team when you have already joined in a team");
            }
            else
            {
                $newteam=new TeamModel();
                $newteam->teamname=$request->teamname;
                $captain->team=$newteam->teamname;
                $newteam->captain=$captain->username;
                $teammate=[0=>$captain->username];
                $str=serialize($teammate);
                $newteam->teammate=$str;
                $captain->save();
                $newteam->save();
                setcookie('creat_team_status',1,time()+120,'/public');
                return redirect('/public/ucenter');
            }
        }
    }
    public function apply(Request $request){
        if(!Auth::check())
        {
            return redirect('/public/login');
        }
        else if(Auth::user()->team!='null')
        {
            return redirect('/public/ucenter')->withErrors([
                'joined_error'=>'你已经加入过战队了',
            ]);
        }
        else
        {
            $wait_user=Auth::user()->username;
//            var_dump($request->teamname);
            $team=TeamModel::where('teamname',$request->teamname)->first();
//            echo $request->teamname;
//            var_dump($team);
            $wait=unserialize($team->wait_rec);
            if(in_array($wait_user,$wait))
            {
                return redirect('/ucenter')->withErrors([
                    'has_in_error'=>'你已经申请过了'
                ]);
            }
            $wait[] = $wait_user;
            $team->wait_rec=serialize($wait);
            $team->save();
            setcookie('please_wait',1,time()+120,'/public');
            return redirect('/public/ucenter');
        }
    }
    Public function accept(Request $request){
        if($request->accept="access")
        {
            $theapplyer=PublicUser::where('username',$request->wait_apply)->first();
            if($theapplyer->team!=='null')
            {
                $team=TeamModel::where('teamname',$request->teamname)->first();
                $wait_user=unserialize($team->wait_rec);
                $wait_user=array_diff($wait_user,[$request->wait_apply]);
                $wait_user=array_values($wait_user);
                $team->wait_rec=serialize($wait_user);
                $team->save();
                setcookie('fail','该用户已加入其他队伍',time()+120,'/public');
                return redirect('/public/ucenter');
            }
            $team=TeamModel::where('teamname',$request->teamname)->first();
            $teammate=unserialize($team->teammate);
            $wait_user=unserialize($team->wait_rec);
            $teammate[] = $request->wait_apply;
            $wait_user=array_diff($wait_user,[$request->wait_apply]);
            $wait_user=array_values($wait_user);
            $team->wait_rec=serialize($wait_user);
            $team->teammate=serialize($teammate);
            $team->save();
            $theapplyer->team=$request->teamname;
            $theapplyer->save();
            return redirect('/public/ucenter');
        }
        else{
            $team=TeamModel::where('teamname',$request->teamname)->first();
            $wait_user=unserialize($team->wait_rec);
            $wait_user=array_diff($wait_user,[$request->wait_apply]);
            $wait_user=array_values($wait_user);
            $team->wait_rec=serialize($wait_user);
            $team->save();
            return redirect('/public/ucenter')->with(['apply_req'=>'已拒绝'.$request->wait_apply]);
        }
    }
    public function  Teamchange(Request $request){
        if(!Auth::check())
        {
            return redirect('/public/login');
        }
        else{
            $team=TeamModel::where('teamname',$request->teamname)->first();
            if($request->change==='移交队长')
            {
                $team->captain=$request->next_captain;
                $team->save();
                setcookie('change',"captain_changed",time()+120,'/public');
                return redirect('/public/ucenter');
            }
            else if($request->change==='删除')
            {
                //查询需要踢出成员的数据，并修改team值
                $the_kicked=PublicUser::where('username',$request->kickedone)->first();
                $the_kicked->team="null";
                $the_kicked->save();
                //修改teammate的数据
                $teammates=$team->teammate;
                $teammates=unserialize($teammates);
                $teammates=array_diff($teammates,[$request->kickedone]);
                $teammates=array_values($teammates);
                $teammates=serialize($teammates);
                $team->teammate=$teammates;
                $team->save();
                return redirect('/public/ucenter');
            }
            else{
                return "please don't post strange things";
            }
        }
    }
}
