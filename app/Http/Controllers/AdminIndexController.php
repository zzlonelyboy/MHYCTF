<?php

namespace App\Http\Controllers;

use App\Models\QuestionModel;
use App\Models\Team\TeamModel;
use App\Models\theuser\PublicUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminIndexController extends Controller
{
    public function  index()
    {
        if(Auth::guard('admin_user')->check())
        {
            $data=[];
            $user=Auth::guard('admin_user')->user();
            $data=['username'=> $user->username,
                'last_login'=>$user->created_at,
            ];
            $public_usr=PublicUser::all();
            $team_list=TeamModel::all();
            $users=[];
            foreach($public_usr as $user)
            {
                $user_data=['username'=>$user->username,
                            'email'=>$user->email,
                            'school'=>$user->school,
                            'team'=>$user->team];
                $users[]=$user_data;
            }
            $teams=[];
            foreach ($team_list as $team)
            {
                $team=['name'=>$team->teamname,
                        'captain'=>$team->captain,
                        'score'=>$team->score,
                        'teammate'=>unserialize($team->teammate)
                                ];
                $teams[]=$team;
            }
            return view('manager')->with(['data'=>$data,'users'=>$users,'teams'=>$teams]);
        }
        else{
            return redirect('/admin/page/login');
        }
    }
}
