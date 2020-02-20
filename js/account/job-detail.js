/**
 * Created by James on 2015-12-11.
 */
$(function() {
    //打开pdf
	$("button[name='btnPdf']").each(function() {
		$(this).on('click',function(){
			document.location = $(this).attr('data-href');
		});
	});
    //返回按钮
    $('#btnDetailReturn').on('click',function(){
       document.location = $('#btnDetailReturn').attr('data-href');
    });
    //确认按钮
    $('#btnDetailConfirm').on('click',function(){
        $(this).attr("disabled","disabled");
        var jobNoNew = $('#txtJobNoNew').val();
        var jobNoNew2 = $('#txtJobNoNew2').val();
        jobNoNew2 = jobNoNew2==undefined?'':jobNoNew2;
        var jobNoNew3 = $('#txtJobNoNew3').val();
        jobNoNew3 = jobNoNew3==undefined?'':jobNoNew3;
        var jobNoNew4 = $('#txtJobNoNew4').val();
        jobNoNew4 = jobNoNew4==undefined?'':jobNoNew4;

        $.ajax({
            type : "GET",
            url : "./api.php",
            data : "q=selectJob&jobNoNew=" + jobNoNew + "&jobNoNew2=" + jobNoNew2 + "&jobNoNew3=" + jobNoNew3 + "&jobNoNew4=" + jobNoNew4,
            dataType : "json",
            success : function(msg) {
                var e = $('#btnDetailConfirm');
                e.popover({placement:'top', content:msg.message}).popover('show');
                if(msg.success){
                    setTimeout("top.location.href='jobs_3.php'", 3000);
                }
            }
        });
    });
});