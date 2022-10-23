<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/all.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/question.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/modal.css")}}">
</head>
<body>
@if(isset($_COOKIE['right']))
    @if($_COOKIE['right']==1)
        <script>alert('sloved')</script>
        <?php setcookie('right','');?>
    @endif
    @if($_COOKIE['right']==0)
        <script>alert('your flag is wrong')</script>
        <?php setcookie('right','');?>
    @endif
    @if($_COOKIE['right']==2)
        <script>alert('you have solved the question')</script>
        <?php setcookie('right','')?>
    @endif
@endif
<h1>&nbsp&nbsp&nbspWeb</h1>
    <div>
        @if(count($data['web'])>0)
            @foreach($data['web'] as $web)
                <div class="question">
                    {{--                            //此处暂时先用input替代--}}
                    <form action="/create_docker" method="post">
                        <h3>[{{$web['comes']}}] {{$web['name']}}</h3>
                        <input name="qu_id" value="{{$web['qid']}}" hidden readonly>
                        <input type="submit"  value='开启容器'}>
                        @csrf
                    </form>
                    <button id="triggerBtn">提交</button>
                </div>
            @endforeach
        @else
            <span>暂无题目</span>
        @endif
    </div>
<h1>&nbsp&nbsp&nbspReverse</h1>
    <div>
        @if(count($data['reverse'])>0)
            @foreach($data['reverse'] as $reverse)
                <div class="question">
                    {{--                            //此处暂时先用input替代--}}
                    <form action="/download" method="post">
                        <h3>[{{$reverse['comes']}}] {{$reverse['name']}}</h3>
                        <input name="qu_id" value="{{$reverse['name']}}" hidden readonly>
                        <input type="submit"  value='开启容器'}>
                        @csrf
                    </form>
                </div>
            @endforeach
        @else
            <span>暂无题目</span>
        @endif
    </div>
<h1>&nbsp&nbsp&nbspPwn</h1>
    <div>
        @if(count($data['pwn'])>0)
            @foreach($data['pwn'] as $pwn)
                <div class="question">
                    {{--                            //此处暂时先用input替代--}}
                    <form action="/create_docker" method="post">
                        <h3>[{{$pwn['comes']}}] {{$pwn['name']}}</h3>
                        <input name="qu_id" value="{{$pwn['qid']}}" hidden readonly>
                        <input type="submit"  value='开启容器'}>
                        @csrf
                    </form>
                </div>
            @endforeach
        @else
            <span>暂无题目</span>
        @endif
    </div>
<h1>&nbsp&nbsp&nbspMisc</h1>
    <div>
        @if(count($data['misc'])>0)
            @foreach($data['misc'] as $misc)
                <div class="question">
                    {{--                            //此处暂时先用input替代--}}
                    <form action="/download" method="post">
                        <h3>[{{$misc['comes']}}] {{$misc['name']}}</h3>
                        <input name="qu_id" value="{{$misc['name']}}" hidden readonly>
                        <input type="submit"  value='开启容器'}>
                        @csrf
                    </form>
                </div>
            @endforeach
        @else
            <span>暂无题目</span>
        @endif
    </div>
<h1>&nbsp&nbsp&nbspCrypto</h1>
    <div>
        @if(count($data['crypto'])>0)
            @foreach($data['crypto'] as $crypto)
                <div class="question">
                    {{--                            //此处暂时先用input替代--}}
                    <form action="/download" method="post">
                        <h3>[{{$crypto['comes']}}] {{$crypto['name']}}</h3>
                        <input name="qu_id" value="{{$crypto['name']}}" hidden readonly>
                        <input type="submit" name="start" value='开启容器'}>
                        <button id="triggerBtn">提交</button>
                        @csrf
                    </form>
                </div>
            @endforeach
        @else
            <span>暂无题目</span>
        @endif
    </div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>flag提交</h2>
            <span id="closeBtn" class="close">×</span>
        </div>
        <div class="modal-body">
            <form action="/public/questions/flag_submit" method="post">
                <input name="flag" style="width:300px;height:35px;"placeholder="flag">
                <input name="qu" value="BabySqli" hidden>
                @csrf
                <input style="width:50px;height:35px;"type="submit" value="提交">
            </form>
        </div>
        <div class="modal-footer">
            <h3>创建你的战队吧！</h3>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="{{URL::asset("js/modal.js")}}"></script>
