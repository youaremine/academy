/*!
 * only for hk-part-time_salary.html
 *
 * Date: 2015-01-22
 */

$(function(){
	$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" })
	
	$('#lock').click(function(){
		var backupMonth = $('#ddlMonth').val();
		//add new backup
		$.ajax({
			type : "GET",
			url : "../api/salary.php",
			data : "q=backupOtherSalary&backupType=sz-part-time&backupMonth="+backupMonth,
			dataType : "json",
			success : function(msg) {
				//msg.mshlId;
				//hide singup form.
				$('#signup').hide();
				$('#lean_overlay').hide();
				//show tips
				showTips( "正在下載Excel文檔.", 35, 5 );
				$('#lock').hide();
				$('#approval').show();
				$('#unlock').show();
				//redirect to download page.
				document.location = 'hk-part-time_salary_to_excel.php?ddlMonth='+backupMonth;
			}
		});
	});
	
	//unlock
	$('#unlock').click(function(){
		var oshlId = $('#oshlId').val();
		$.ajax({
			type : "GET",
			url : "../api/salary.php",
			data : "q=unbackupOtherSalary&oshlId="+oshlId,
			dataType : "json",
			success : function(msg) {
				//hide singup form.
				$('#signup').hide();
				$('#lean_overlay').hide();
				$('#unlock').hide();
				$('#approval').hide();
				$('#lock').show();
				//show tips
				showTips( "撤銷鎖定成功!.", 35, 10 );
			}
		});
	});
	
	//approval
	$('#approval').click(function(){
		var oshlId = $('#oshlId').val();
		$.ajax({
			type : "GET",
			url : "../api/salary.php",
			data : "q=approvalBackupOtherSalary&oshlId="+oshlId,
			dataType : "json",
			success : function(msg) {
				//hide singup form.
				$('#signup').hide();
				$('#lean_overlay').hide();
				$('#unlock').hide();
				$('#approval').hide();
				$('#unapproval').show();
				//show tips
				showTips( "審核成功!.", 35, 10 );
			}
		});
		
	});

	$('#unapproval').click(function(){
		var oshlId = $('#oshlId').val();
		$.ajax({
			type : "GET",
			url : "../api/salary.php",
			data : "q=unapprovalBackupOtherSalary&oshlId="+oshlId,
			dataType : "json",
			success : function(msg) {
				//hide singup form.
				$('#signup').hide();
				$('#lean_overlay').hide();
				$('#unapproval').hide();
				$('#unlock').show();
				$('#approval').show();
				//show tips
				showTips( "撤銷審核成功!.", 35, 10 );
			}
		});
		
	});
	
});