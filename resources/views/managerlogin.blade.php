<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/all.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/login.css")}}">
    <title>Document</title>
</head>
<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul><script>alert('@foreach ($errors->all() as $error)
                    {{ $error }}@endforeach')//此处需使弹窗规范整齐
            </script>
        </ul>
    </div>
@endif
<div class="header">
    <h1>管理员登录</h1>
</div>
<div class="navbar">
    <a href="/public/login">返回登陆界面</a>
</div>
<div class="login_box">
    <div>
        <form action="/admin/login" method="post">
            <input name="username" id="username" placeholder="用户名" class="input_box"><br>
            <input name="password" id="password" placeholder="密码" class="input_box"><br>
            <input name="captcha" id="captcha" placeholder="验证码" class="input_box">
            <img class="captcha" alt="captcha" id="checkcode" onclick='change()' src='{{captcha_src('ctfcode')}}'><br>
            <!--<input type="checkbox" name="remember" class="remember">记住我<br>-->
            <input class="button_box" name=submit type="submit" id="btn_login" value="登录"/>
            @csrf
        </form>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="{{URL::asset("js/login.js")}}"></script>

