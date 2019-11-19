/**
 * Created by James on 2015-12-11.
 */
function setLoginTips(msg){
    $('#btnLogin').popover({placement:'top', content:msg}).popover('show');
    setTimeout("$('#btnLogin').popover('destroy');", 3000);
}
$(function() {
    $('#btnLogin').on('click',function(){
        var username = $('#username').val();
        var password = $('#password').val();
        var antispam = $('#antispam').val();
        if(username == ''){
            setLoginTips('請輸入用戶名');
            return false;
        }
        if(password == ''){
            setLoginTips('請輸入密碼');
            return false;
        }
        if(antispam == ''){
            setLoginTips('請輸入驗證碼');
            return false;
        }
        $.ajax({
            type : "POST",
            url : "./login.php",
            data : $('#formLogin').serialize(),
            dataType : "json",
            success : function(data) {
                if(data.success){
                    setLoginTips(data.message);
                    setTimeout("top.location.href='index.php'", 500);
                }else{
                    setLoginTips(data.message);
                }
            }
        });
    });
});