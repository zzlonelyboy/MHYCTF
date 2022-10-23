<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/all.css")}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset("css/modal.css")}}">
</head>
<body>
<div class="header">
    <h1>用户中心</h1>
</div>
<div class="navbar">
    <a href="/public/index">主页</a>
    <a href="/public/logout" class="right">登出</a>
</div>
@if(isset($_COOKIE['creat_team_status']))
    <script>alert('战队创建成功')</script>
        <?php setcookie('creat_team_status','');?>
@endif
@if(isset($_COOKIE['please_wait']))
    <script>alert('请等待战队审批')</script>
        <?php setcookie('please_wait','')?>
@endif
@if(isset($_COOKIE['change'])&&$_COOKIE['change']=='captain_changed')
    <script>alert('队长已移交')</script>
        <?php setcookie('change','')?>
@endif
@if(isset($_COOKIE['fail']))
    <script>alert('该用户已加入其他战队')</script>
    <?php setcookie('fail','')?>
@endif
<div class="row">
    <div class="side">
        <h2>基本信息</h2>
        <table border="1" cellpadding="10">
            <tr>
                <th>用户名</th><td>{{$data['username']}}</td>
            </tr>
            <tr>
                <th>学校</th><td>{{$data['school']}}</td>
            </tr>
            <tr>
                <th>战队</th><td>{{$data['team']}}</td>
            </tr>
            <tr></tr>
        </table>
    </div>
    <div class="main">
        <h2>战队管理</h2>
        @if($team)
            <table border="1" cellpadding="10">
                <tr><th>成员列表</th></tr>
                <tr>
                    @foreach(unserialize($team['teammate']) as $teammate)
                        @if($teammate!=$data['username'])
                        <td>{{$teammate}}</td>
                        <td>
                            <form action="/public/team/teamchange" method="post">
                                <input name="next_captain" value={{$teammate}} hidden>
                                <input name="kickedone" value={{$teammate}} hidden>
                                <input name="teamname" value="{{$data['team']}}"hidden>
                                <input type="submit" name="change" value="删除">
                                <input type="submit" name="change" value="移交队长">
                                @csrf
                            </form>
                        </td>
                        @endif
                </tr>
                @endforeach
                <tr><th>待审批</th>
                    @foreach(unserialize($team['wait_rec']) as $wait_apply)
                        <td><form action="/public/team/accept" method="post">
                                <span>{{$wait_apply}}</span>
                                <input name="wait_apply" hidden value="{{$wait_apply}}">
                                <input name="teamname" value="{{$team['teamname']}}" hidden >
                                <input type="submit" name="accept" value="接受">
                                <input type="submit" name="accept" value="拒绝">
                                @csrf
                            </form></td>
                </tr>
                @endforeach
            </table>
            {{--            <a href="/public/team/page/change">成员变更</a>--}}
        @endif
        <br>
        <button id="triggerBtn">创建战队</button>
        <!-- 模态框 -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>创建战队</h2>
                    <span id="closeBtn" class="close">×</span>
                </div>
                <div class="modal-body">
                    <form action="/public/team/create" method="post">
                        <lable for="team_name"></lable><input style="width:300px;height:35px;" name="teamname" id="team_name" placeholder="请输入战队名称">
                        @csrf
                        <input style="width:50px;height:35px;"type="submit" value="提交">
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
                </div>
                <div class="modal-footer">
                    <h3>创建你的战队吧！</h3>
                </div>
            </div>
        </div>
        <button id="triggerBtn2">加入战队</button>
        <!-- 模态框 -->
        <div id="myModal2" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>加入战队</h2>
                    <span id="closeBtn2" class="close">×</span>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <h3>加入战队，和队友并肩作战！</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <h2>MHYCTF</h2>
</div>
</body>
<script type="text/javascript" src="{{URL::asset("js/modal.js")}}"></script>
</html>
