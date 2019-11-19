$(document).ready(function(){
	$('#aByWeek').bind('click', function() {
		$('#trByWeek').show();
		$('#trByDate').hide();
		$('#hidByType').val('week');
	});
	
	$('#aByDate').bind('click', function() {
		$('#trByDate').show();
		$('#trByWeek').hide();
		$('#hidByType').val('date');
	});

});

/**
 * 删除该调查时间
 * @param sftiId
 */
function DelFreeTime(sftiId)
{
	$.ajax({
		type : "GET",
		url : "../api/surveyor-assign.php",
		data : "q=surveyorDelFreeTime&sftiId=" + sftiId,
		dataType : "json",
		success : function(msg) {
			$('#row_'+sftiId).hide();
			showTips( "已經移除,並標記該時間段為空閒.", 35, 60 );
		}
	});
}