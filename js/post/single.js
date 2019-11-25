/**
 * Created by James on 2017-04-23.
 */
function showTips(msg){
    $('#btnSend').popover({placement:'top', content:msg}).popover('show');
    setTimeout("$('#btnSend').popover('destroy');", 3000);
}

$(function() {
    template.helper("brReplace",function(str){
        return str.replace(/\r\n/ig,"<br />");
    });
    $.getJSON('../api/post.php?q=getList&jobNoNew='+jobNoNew, function(data) {
        var _html = template('tpl_chat_history', data);
        $('#chat_history_list').html(_html);
        setTimeout(function(){
            var scrollHeight = $('body').prop("scrollHeight");
            $(document).scrollTop(scrollHeight);
        },200)

    });

    $("#btnSend").on("click",function(){
        if($('#content').val() == ''){
            showTips('請輸入內容');
            return false;
        }
        $.ajax({
            type : "POST",
            url : "../api/post.php?q=add",
            data : $('#formPost').serialize(),
            dataType : "json",
            success : function(data) {
                if(data.status = "success"){
                    showTips(data.msg);
                    setTimeout("location.replace(location.href);", 2000);
                }else{
                    showTips(data.msg);
                }
            }
        });
    });
});

