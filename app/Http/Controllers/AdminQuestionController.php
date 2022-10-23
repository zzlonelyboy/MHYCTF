<?php

namespace App\Http\Controllers;

use App\Models\theuser\PublicUser;
use Illuminate\Http\Request;
use App\Models\QuestionModel;
use Illuminate\Support\Facades\Storage;

class AdminQuestionController extends Controller
{
    public function question_manage(){
        $web=QuestionModel::where('class','web')->get();
        $pwn=QuestionModel::where('class','pwn')->get();
        $reverse=QuestionModel::where('class','reverse')->get();
        $misc=QuestionModel::where('class','misc')->get();
        $crypto=QuestionModel::where('class','crypto')->get();
        $data=['web'=>$web,'pwn'=>$pwn,'reverse'=>$reverse,'misc'=>$misc,'crypto'=>$crypto];
        return view('question_manage')->with('data',$data);
    }
    //删除特定文件夹及其中内容
    public function delDir(string $path): bool
    {
        if (is_file($path)) {
            return unlink($path);
        }
        $open = opendir($path);
        if (!$open) {
            return false;
        }
        while (($v = readdir($open)) !== false) {
            if ('.' == $v || '..' == $v) {
                continue;
            }
            $item = $path . '/' . $v;
            if (is_file($item)) {
                unlink($item);
                continue;
            }
            $this->delDir($item);
        }
        closedir($open);
        return rmdir($path);
    }

    //文件解压函数
    public function exzip($filename,$filepath){
        $zip=new \ZipArchive();
        $zip->open($filepath.$filename.'.zip',);
        $zip->extractTo($filepath);
    }
    //
    public function Qu_upload(Request $request)
    {
        if($request->method()=='POST')
        {
            if($request->hasFile('new_QU')&&$request->file('new_QU')->isValid())
            {
                $file=$request->file('new_QU');
                $oldname=$file->getClientOriginalName();
                $pt=strrpos($oldname,'.');
                $oldname=substr($oldname,0,$pt);
                $question=QuestionModel::where('name',$oldname)->where('comes',$request->comes)->get();
                if(!$question->isEmpty())
                {
                    return redirect('/admin/question_manage')->withErrors('上传文件重复');
                }
                $filename=md5(time().rand(0,65535).$oldname);
                $filepath='D:/phpstudy_pro/question/';//此处使用绝对路径
                $file->move($filepath,$filename.'.zip');
                //将压缩文件解压
                if($request->type=='web')
                {
                    $this->exzip($filename,$filepath);
                    //删除压缩文件
                    unlink($filepath.$filename.'.zip');
                }
                $newfile=new QuestionModel();
                $newfile->qid=strval($filename);
                $newfile->name=$oldname;
                $newfile->score=$request->score;
                $newfile->class=$request->type;
                $newfile->comes=$request->comes;
                $newfile->now_exit=0;
                $newfile->flag=$request->flag;
                if($request->type=='web')
                {
                    $newfile->path=$filepath.$oldname;
                }
                else $newfile->path=$filepath.$filename.'.zip';
                $newfile->save();
                setcookie('upload_status',1);
                return redirect('/admin/question_manage');
            }
            else{
                return redirect('/admin/question_manage')->withErrors('上传失败');
            }
        }
    }
    public function remove_question(Request $request)
    {
        if($request->method()=='POST')
        {
            $question=QuestionModel::where('qid',$request->qid)->first();
            $users=PublicUser::all();
            foreach ($users as $user)
            {
                $tried=$user->try_question;
                $slove=$user->slove;
                $tried=unserialize($tried);
                $slove=unserialize($slove);
                $tried=array_diff($tried,[$question->name]);
                $slove=array_diff($slove,[$question->name]);
                $tried=array_values($tried);
                $slove=array_values($slove);
                $tried=serialize($tried);
                $slove=serialize($slove);
                $user->try_question=$tried;
                $user->slove=$slove;
                $user->save();
            }
            $path=$question->path;
            $this->delDir($path);
            QuestionModel::where('qid',$request->qid)->first()->delete();
            return redirect('/admin/question_manage');
        }
        else{
            return "error request method";
        }
    }
}
