function change(){
    var src=document.getElementById('checkcode').getAttribute('src');
    document.getElementById('checkcode').setAttribute('src',src+Math.random());
}

