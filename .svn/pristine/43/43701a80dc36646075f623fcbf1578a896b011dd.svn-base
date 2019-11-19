/*!
 * only for surveyor_calendar.html
 *
 * Date: Jan 29 2013
 */

$(function(){
	//check the checkbox
	$(':checkbox').click(function(){
		if($("input[name='"+this.id+"']").attr("checked"))
		{
			var index = $("input[name='"+this.id+"']").val();
			switch(this.id)
			{
				case "unknow["+index+"]":
					$("input[name='fullBusy["+index+"]']").attr("checked",false);
					$("input[name='fullFree["+index+"]']").attr("checked",false);
					$("input[name='am["+index+"]']").attr("checked",false);
					$("input[name='pm["+index+"]']").attr("checked",false);
					$("input[name='night["+index+"]']").attr("checked",false);
					break;
				case "fullBusy["+index+"]":
					$("input[name='unknow["+index+"]']").attr("checked",false);
					$("input[name='fullFree["+index+"]']").attr("checked",false);
					$("input[name='am["+index+"]']").attr("checked",false);
					$("input[name='pm["+index+"]']").attr("checked",false);
					$("input[name='night["+index+"]']").attr("checked",false);
					break;
				case "fullFree["+index+"]":
					$("input[name='unknow["+index+"]']").attr("checked",false);
					$("input[name='fullBusy["+index+"]']").attr("checked",false);
					$("input[name='am["+index+"]']").attr("checked",false);
					$("input[name='pm["+index+"]']").attr("checked",false);
					$("input[name='night["+index+"]']").attr("checked",false);
					break;
				case "am["+index+"]":
					$("input[name='unknow["+index+"]']").attr("checked",false);
					$("input[name='fullBusy["+index+"]']").attr("checked",false);
					$("input[name='fullFree["+index+"]']").attr("checked",false);
					break;
				case "pm["+index+"]":
					$("input[name='unknow["+index+"]']").attr("checked",false);
					$("input[name='fullBusy["+index+"]']").attr("checked",false);
					$("input[name='fullFree["+index+"]']").attr("checked",false);
					break;
				case "night["+index+"]":
					$("input[name='unknow["+index+"]']").attr("checked",false);
					$("input[name='fullBusy["+index+"]']").attr("checked",false);
					$("input[name='fullFree["+index+"]']").attr("checked",false);
					break;
			}
		}
	});
	
	$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });
	
	//init date value
	$('a[rel*=leanModal][href=#freeTimeDialog]').click(function(){
		$('#currDay').val(this.id);
		$('#startTime').val('');
		$('#endTime').val('');
	});
	
	//update planned survey date
	$('#btnfreeTimeSubmit').click(function(){
		//TODO
	});
	
});