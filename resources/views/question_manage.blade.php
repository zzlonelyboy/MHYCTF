<!DOCTYPE html>
<html>
<head>
    <title>MHYCTF</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/all.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/quesionmanager.css")}}">
</head>
<body>

<div class="header">
    <h1>题库管理</h1>
</div>
@if(isset($_COOKIE['upload_status']))
    <script>alert('upload_status')</script>
    <?php setcookie('upload_status','');?>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul><script>alert('@foreach ($errors->all() as $error)
                    {{ $error }}@endforeach')//此处需使弹窗规范整齐
            </script>
        </ul>
    </div>
@endif
<div class="row">
    <div class="side1">
        <h2>题目类型</h2>
        <h5>Web</h5>
        <div>
            <table border="1" cellpadding="10">
                @if(count($data['web'])>0)
                    <tr>
                        <th>id</th>
                        <td>题目</td>
                        <td>出处</td>
                        <td>存储路径</td>
                        <td>现有容器</td>
                    </tr>
                    @foreach($data['web'] as $web)
                        <tr>
                            <td>{{$web['qid']}}</td>
                            <td>{{$web['name']}}</td>
                            <td>{{$web['comes']}}</td>
                            <td>{{$web['path']}}</td>
                            <td>{{$web['now_exit']}}</td>
                            <td>
                                <form action="/admin/question_remove" method="post">
                                    @csrf
                                    <input name="qid" value={{$web['qid']}} hidden>
                                    <input type="submit" name="delete" value="删除">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <span>暂无题目</span>
                @endif
            </table>

        </div>
        <h5>Reverse</h5>
        <div class="fakeimg" style="height:200px;">
            <table border="1" cellpadding="10">
            @if(count($data['reverse'])>0)
                <tr>
                    <td>id</td>
                    <td>题目</td>
                    <td>出处</td>
                    <td>存储路径</td>
                    <td>现有容器</td>
                </tr>
                @foreach($data['reverse'] as $reverse)
                    <tr>
                        <td>{{$reverse['qid']}}</td>
                        <td>{{$reverse['name']}}</td>
                        <td>{{$reverse['comes']}}</td>
                        <td>{{$reverse['path']}}</td>
                        <td>{{$reverse['now_exit']}}</td>
                        <td>
                            <form action="/admin/question_remove" method="post">
                                @csrf
                                <input name="qid" value={{$reverse['qid']}} hidden>
                                <input type="submit" name="delete" value="删除">
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <span>暂无题目</span>
                @endif
                </table>
        </div>
        <h5>pwn</h5>
        <div class="fakeimg" style="height:200px;">
            <table border="1" cellpadding="10">
            @if(count($data['pwn'])>0)
                <tr>
                    <td>id</td>
                    <td>题目</td>
                    <td>出处</td>
                    <td>存储路径</td>
                    <td>现有容器</td>
                </tr>
                @foreach($data['pwn'] as $pwn)
                    <tr>
                        <td>{{$pwn['qid']}}</td>
                        <td>{{$pwn['name']}}</td>
                        <td>{{$pwn['comes']}}</td>
                        <td>{{$pwn['path']}}</td>
                        <td>{{$pwn['now_exit']}}</td>
                        <td>
                            <form action="/admin/question_remove" method="post">
                                @csrf
                                <input name="qid" value={{$pwn['qid']}} hidden>
                                <input type="submit" name="delete" value="删除">
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <span>暂无题目</span>
                @endif
                </table>
        </div>
        <h5>misc</h5>
        <div class="fakeimg" style="height:200px;">
            <table border="1" cellpadding="10">
            @if(count($data['misc'])>0)
                <tr>
                    <td>id</td>
                    <td>题目</td>
                    <td>出处</td>
                    <td>存储路径</td>
                </tr>
                @foreach($data['misc'] as $misc)
                    <tr>
                        <td>{{$misc['qid']}}</td>
                        <td>{{$misc['name']}}</td>
                        <td>{{$misc['comes']}}</td>
                        <td>{{$misc['path']}}</td>
                        <td>
                            <form action="/admin/question_remove" method="post">
                                @csrf
                                <input name="qid" value={{$misc['qid']}} hidden>
                                <input type="submit" name="delete" value="删除">
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <span>暂无题目</span>
                @endif
                </table>
        </div>
        <h5>crypto</h5>
        <div class="fakeimg" style="height:200px;">
            <table border="1" cellpadding="10">
            @if(count($data['crypto'])>0)
                <tr>
                    <td>id</td>
                    <td>题目</td>
                    <td>出处</td>
                    <td>存储路径</td>
                </tr>
                @foreach($data['crypto'] as $crypto)
                    <tr>
                        <td>{{$crypto['qid']}}</td>
                        <td>{{$crypto['name']}}</td>
                        <td>{{$crypto['comes']}}</td>
                        <td>{{$crypto['path']}}</td>
                        <td>
                            <form action="/admin/question_remove" method="post">
                                @csrf
                                <input name="qid" value={{$crypto['qid']}} hidden>
                                <input type="submit" name="delete" value="删除">
                            </form>
                        </td>
                    </tr>>
                @endforeach
            @else
                <span>暂无题目</span>
                @endif
                </table>
        </div>
    </div>
    <div class="main1">
        <form action="/admin/question_upload" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="comes" required placeholder="出处"><br>
            <input name="type" type="text" list="typelist" placeholder="请选择" required><br>
            <input name="score" type="text" required placeholder="分数"><br>
            <input name="flag" type="text" required placeholder="flag"><br>
            <datalist id="typelist">
                　　 <option>web</option>
                　　 <option>misc</option>
                <option>reverse</option>
                <option>pwn</option>
                <option>crypto</option>
            </datalist>
            <input type="file" name="new_QU" required>
            <button type="submit">提交</button>
        </form>
    </div>
</div>

<div class="footer">
    <h2>MHYCTF</h2>
</div>

</body>
</html>
