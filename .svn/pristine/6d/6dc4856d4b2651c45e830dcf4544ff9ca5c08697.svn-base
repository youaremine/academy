/**
 * 審核其它薪金
 * @param otId
 */
function Audit(otId){
	$.ajax({
		type : "GET",
		url : "../api/other-salary.php",
		data : "q=audit&otId=" + otId,
		dataType : "json",
		success : function(msg) {
			//隱藏審核按鈕
			$("#Audit_"+otId).hide();
			//标记该条记录为已审核
			$("#AuditImg_"+otId).attr("src","../images/audited.png");
			showTips("審核成功!",35, 5);
		}
	});
}
