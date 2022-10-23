<?php

namespace App\Http\Controllers;
use App\Models\QuestionModel;
use App\Models\Team\TeamModel;
use App\Models\theuser\PublicUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicQuestionController extends Controller
{
    //
    public  function DockerCTF($obj)
    {
        $shell1 = 'cd '.$obj['path'].'/dockerfile/'.'&d:&docker build -t '.$obj["name"].' .&docker run --name '.$obj["name"].' -i -d -P '.$obj["name"];
        $shell2 = 'docker exec -u root '.$obj["name"].' /bin/bash -c "service mysql start"';
        $shell3 = 'docker ps -a --format "table {{.Ports}}"';
//        echo $shell1;
//        echo $shell2;
//        echo $shell3;
         exec($shell1);
         exec($shell2);
         exec($shell3,$output);
         return $output;
    }
    function DockerDelete($obj)
    {
        $shell1= 'docker stop '.$obj["name"];
        $shell2 = 'docker rm '.$obj["name"];
        system($shell1);
        system($shell2);
    }
    public function download(Request $request)
    {
        $request->qu_name;
        $qu=QuestionModel::where('name',$request->qu_name)->first();
        $path=$qu->path;
        $down_host = $_SERVER['HTTP_HOST'];
// 如果文件存在,则跳转到下载路径
        if (file_exists($path)) {
            return response()->download($path,$qu->name.'zip');
        } else {
            header('HTTP/1.1 404 Not Found');
        }
    }
    public function create_docker(request $request)
    {
        $user=Auth::user();
        $qu=QuestionModel::where('qid',$request->qu_id)->first();
        $obj=['path'=>$qu->path,'name'=>strtolower($qu->name.'_'.$user->id)];
        $port=$this->DockerCTF($obj)[1];
        $pos=strrpos($port,':');
        $end=strrpos($port,'-');
        if($pos)
        {
            $port=substr($port,$pos+1,$end-$pos-1);
            if(!$qu->port)
            {
                $the_port=[$user->name=>$port];
                $the_port=serialize($the_port);
                $qu->port=$the_port;
            }
            else
            {
                $the_port=unserialize($qu->port);
                $the_port+=[$user->name=>$port];
            }
            return '题目的端口号为：'.$port;
        }
        else{
            return '生成失败';
        }
    }
    public function flag_submit(Request $request){
    $user=Auth::user();
    $qu=QuestionModel::where('name',$request->qu)->first();
    $the_sloves=unserialize($user->slove);
    if(in_array($qu->name,$the_sloves))
    {
        setcookie('right',2,time()+120);
        return redirect('/public/questions');
    }
    else
    {
        if($qu->flag===$request->flag){
            $user=PublicUser::where('username',$user->username)->first();
            $user->slove=unserialize($user->slove);
            $user->try_question=unserialize($user->try_question);
            $sloved=$user->slove;
            $tried=$user->try_question;
            $tried[]=$qu->name;
            $sloved[]=$qu->name;
            $user->slove=serialize($sloved);
            $user->try_question=serialize($tried);
            $user->score+=$qu->score;
            $user->save();
            $obj=['name'=>strtolower($qu->name.'_'.$user->id)];
            $this->DockerDelete($obj);
            if($user->team!='null'){
                $team=TeamModel::where('teamname',$user->team)->first();
                $team->score+=$qu->score;
                $team->save();
            }
            setcookie('right',1,time()+120);
            return redirect('/public/questions');
        }
        else{
            $user=Auth::user();
            $user=PublicUser::where('username',$user->username)->first();
            $user->try_question=unserialize($user->try_question);
            $tried=$user->try_question;
            $tried[]=$qu->name;
            $user->try_question=serialize($tried);
            setcookie('right',0,time()+120);
            return redirect('/public/questions');
        }
    }
    }
}
