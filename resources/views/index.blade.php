<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/all.css")}}">
    <title>Document</title>
</head>
<body>
<div class="header">
    <h1>欢迎，{{$data['username']}}</h1>
    <p>您上一次登陆时间是：:{{$data['last_login']}}</p>
</div>
<div class="navbar">
    <a href="/public/ucenter">用户中心</a>
    <a href="/public/questions">题目</a>
    <a href="/public/logout">登出</a>
</div>

<div class="main">
    <h2>您做过的题目：</h2>
    @foreach($data['solve'] as $solve)
        <span>{{$solve}}</span>
    @endforeach
</div>
<div class="footer">
    <h2>MHYCTF</h2>
</div>
</body>
</html>
