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
<div class="alert alert-danger">
    <ul>
        @if(count($errors)>0)
            @if(is_object($errors))
                @foreach($errors->all() as $error)
                    {{$error}}
                @endforeach
            @else
                {{$errors}}
            @endif
        @endif
    </ul>
</div>
    <h1>join in a team</h1>
    <p>战队列表</p>
    <div>
        @foreach ($teams as $team)
                <form action="/public/team/apply" method="post">
                    <span>{{$team->teamname}} </span>
                    <label for="teamname"></label> <input name="teamname" id="teamname" value="{{$team->teamname}}" hidden>
                        <input type="submit" value="申请">
                    @csrf
                </form>
        @endforeach
    </div>
</body>
</html>
