
function change(){
    var src=document.getElementById('checkcode').getAttribute('src');
    document.getElementById('checkcode').setAttribute('src',src+Math.random());
}
$("#login").click(function () {
    $.ajax({
        type: "POST",   //提交的方法
        url:"/public/pulogin", //提交的地址
        data:$('#myForm').serialize(),// 序列化表单值
        async: false,
        error: function(request) {  //失败的话
            alert("Connection error");
        },
        success: function(data) {  //成功
            window.location.href="/public/index"
        }
    });
});
