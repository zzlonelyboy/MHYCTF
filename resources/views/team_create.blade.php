<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/public/team/create" method="post" >
        <lable for="team_name"></lable><input name="teamname" id="team_name" placeholder="请输入战队名称">
        @csrf
        <input type="submit" value="submit">
    </form>
    @if(count($errors)>0)
        @if(is_object($errors))
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
        @else
            {{$errors}}
        @endif
    @endif
</body>
</html>
