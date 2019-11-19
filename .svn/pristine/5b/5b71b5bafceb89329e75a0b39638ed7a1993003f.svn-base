/**
 * Created by James on 2017-04-29.
 */
function setLoginTips(msg){
    $('#btnRegister').popover({placement:'top', content:msg}).popover('show');
    setTimeout("$('#btnRegister').popover('destroy');", 3000);
}
$(function() {
    $('#btnRegister').on('click',function(){
        var engName = $('#engName').val();
        var contact = $('#contact').val();
        var survHome = $('#survHome').val();
        var remarks = $('#remarks').val();
        if(engName == ''){
            setLoginTips('請輸入姓名');
            return false;
        }
        if(contact == ''){
            setLoginTips('請輸入手提號碼');
            return false;
        }
        if(survHome == ''){
            setLoginTips('請輸入住址');
            return false;
        }
        if(remarks == ''){
            setLoginTips('請輸入備註');
            return false;
        }
        $.ajax({
            type : "POST",
            url : "./register.php",
            data : $('#formRegister').serialize(),
            dataType : "json",
            success : function(data) {
                if(data.success){
                    setLoginTips(data.message);
                    setTimeout("top.location.href='pending.php'", 500);
                }else{
                    setLoginTips(data.message);
                }
            }
        });
    });
});