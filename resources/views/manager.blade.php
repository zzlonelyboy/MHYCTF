<!DOCTYPE html>
<html>
<head>
    <title>{{$data['username']}}的主页</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/all.css")}}">
</head>
<body>

<div class="header">
    <h1>欢迎，管理员{{$data['username']}}</h1>
    <p>您上一次登陆时间是：:{{$data['last_login']}}</p>
</div>

<div class="navbar">
    <a href="/admin/question_manage">题目管理</a>
    <a href="/admin/logout" class="right">登出</a>
</div>

<div class="row">
    <div class="side">
        <h1>用户概览</h1>
        <table border="1" cellpadding="10">
            <tr>
                <td>用户名</td>
                <td>邮箱</td>
                <td>战队</td>
            </tr>
        @foreach($users as $user)
                <tr>
                    <td>{{$user['username']}}</td>
                    <td>{{$user['email']}}</td>
                    <td>{{$user['team']}}</td>
                    <td>{{$user['school']}}</td>
                    <td>
                        <form action="/admin/userchange" method="post">
                            <input name="username" value="{{$user['username']}}" hidden>
                            <input type="submit" name="change" value="删除">
                        @csrf
                        </form>
                    </td>
                </tr>
        @endforeach
        </table>
    </div>
    <div class="main">
        <h1>战队</h1>
        <table border="1" cellpadding="10">
            <tr>
                <td>战队名称</td>
                <td>队长</td>
                <td>分数</td>
{{--                <td>队员</td>--}}
            </tr>
            <?php $b=0;?>
            @foreach($teams as $team)
                    <?php if($b==20) break;?>
                <tr>
                    <td>{{$team['name']}}</td>
                    <td>{{$team['captain']}}</td>
                    <td>{{$team['score']}}</td>
                    <td>
                        @foreach($team['teammate'] as $teammate)
                            <span>{{$teammate}}</span>
                        @endforeach
                    </td>
                    <td>
                        <form action="/admin/teamchange" method="post">
                            <input name="teamname" value="{{$team['name']}}" hidden>
                            <input type="submit" name="change" value="删除">
                            @csrf
                        </form>
                    </td>
                </tr>
                    <?php $b++?>
            @endforeach
        </table>
    </div>
</div>

<div class="footer">
    <h2>MHYCTF</h2>
</div>

</body>
</html>
