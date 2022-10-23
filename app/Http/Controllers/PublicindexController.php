<?php

namespace App\Http\Controllers;

use App\Models\QuestionModel;
use App\Models\Team\TeamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicindexController extends Controller
{
    public function  index()
    {
        if(Auth::check())
        {
            $data=[];
            $user=Auth::guard('public_user')->user();
            $data=['username'=> $user->username,
                    'last_login'=>$user->created_at,
                    'solve'=>unserialize($user->slove),
                    'tried'=>unserialize($user->try_question)
                    ];
            return view('index')->with(['data'=>$data]);
        }
        else{
            return redirect('public/login');
        }
    }
    public function  ucenter()
    {
        if(Auth::check())
        {
            $data=[];
            $user=Auth::guard('public_user')->user();
            $team=TeamModel::where('captain',$user->username)->first();
            $data=['username'=> $user->username,
                'last_login'=>$user->created_at,
                'school'=>$user->school,
                'try_question'=>unserialize($user->try_question),
                'solved'=>unserialize($user->solved),
                'team'=>$user->team,
                ];
            $teams=TeamModel::all();
            return view('ucenter')->with(['data'=>$data,'team'=>$team,'teams'=>$teams]);
        }
        else{
            return redirect('public/login');
        }
    }
    public function questions(){
        if(Auth::check())
        {
            $web=QuestionModel::where('class','web')->get(['qid','name','comes','class','port']);
            $pwn=QuestionModel::where('class','pwn')->get(['qid','name','comes','class','port']);
            $reverse=QuestionModel::where('class','reverse')->get(['qid','name','comes','class','port']);
            $misc=QuestionModel::where('class','misc')->get(['qid','name','comes','class','port']);
            $crypto=QuestionModel::where('class','crypto')->get(['qid','name','comes','class','port']);
            $data=['web'=>$web,'pwn'=>$pwn,'reverse'=>$reverse,'misc'=>$misc,'crypto'=>$crypto];
            return view('question_page')->with('data',$data);
        }
    }
}
