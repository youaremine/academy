var isShowDialog = false;
//打开模式窗口
function openSurveyorModalDialog(jobNoNew, openUrl, width, height,
		returnTextIDs) {
	if(!isShowDialog){
		isShowDialog = true;
		var retValue = window.showModalDialog(openUrl, '', 'dialogWidth:' + width
						+ 'px;dialogHeight:' + height
						+ 'px;status:no;scroll:auto;help:no;');
	}
	//for chrome   
	if (retValue == undefined) {  
		retValue = window.returnValue;  
	}
	isShowDialog = false;
	if (retValue != null) {
		var arrReturnValues = retValue.split("|");
		var arrReturnValueCount = arrReturnValues.length;
		$.ajax({
			type : "GET",
			dataType : "json",
			url : "assign/assign-action.php",
			data : "action=assign&jobNoNew=" + jobNoNew + "&survId="
					+ arrReturnValues[0],
			success : function(msg) {
				var arrTextBoxIDs = returnTextIDs.split("|");
				var arrTextBoxIDCount = arrTextBoxIDs.length;

				if (arrTextBoxIDCount > 0 && arrReturnValueCount > 0) {
					for ( var i = 0; i < arrTextBoxIDCount; i++) {
						try {
							if (document.getElementById(arrTextBoxIDs[i]) != null) {
								document.getElementById(arrTextBoxIDs[i]).innerHTML = arrReturnValues[i];
								if (i === 0) {
									var tmpJobNoNew = jobNoNew;
									tmpJobNoNew = tmpJobNoNew.replace("(","\\(");
									tmpJobNoNew = tmpJobNoNew.replace(")","\\)");
									$("#Assign_" + tmpJobNoNew).hide();
									$("#UnAssign_" + tmpJobNoNew).show();
								}
							}
						} catch (er) {
						}
					}
				}
				showTips( jobNoNew + ":" + msg.msg, 35, 5 );
			}
		});
	}
}

function DelAssignSurveyor(jobNoNew, returnTextIDs) {
	$.ajax({
		type : "GET",
		url : "assign/assign-action.php",
		data : "action=unassign&jobNoNew=" + jobNoNew,
		dataType : "json",
		success : function(msg) {
			var arrTextBoxIDs = returnTextIDs.split("|");
			var arrTextBoxIDCount = arrTextBoxIDs.length;
			for ( var i = 0; i < arrTextBoxIDCount; i++) {
				try {
					if (document.getElementById(arrTextBoxIDs[i]) != null) {
						document.getElementById(arrTextBoxIDs[i]).innerHTML = "";
						if (i === 0) {
							var tmpJobNoNew = jobNoNew;
							tmpJobNoNew = tmpJobNoNew.replace("(","\\(");
							tmpJobNoNew = tmpJobNoNew.replace(")","\\)");
							$("#Assign_" + tmpJobNoNew).show();
							$("#UnAssign_" + tmpJobNoNew).hide();
						}
					}
				} catch (er) {
				}
			}
			showTips( jobNoNew + ":" + msg.msg, 35, 5 );
		}
	});
}

/**
 * 該調查員拒絕該Job
 * @param jobNoNew
 * @param survId
 */
function RejectJob(jobNoNew,survId)
{
	$.ajax({
		type : "GET",
		url : "../api/surveyor-assign.php",
		data : "q=surveyorRejectJob&jobNoNew=" + jobNoNew+"&survId=" + survId,
		dataType : "json",
		success : function(msg) {
			$('#row_'+jobNoNew).hide();
			showTips( jobNoNew+"已經移除,並標記調查員("+survId+")該時間段為忙碌. <a href='javascript:UnRejectJob(\""+jobNoNew+"\",\""+survId+"\");'>撤銷</a>", 35, 60 );
		}
	});
}

/**
 * 該調查員拒絕該Job
 * @param jobNoNew
 * @param survId
 */
function UnRejectJob(jobNoNew,survId)
{
	$.ajax({
		type : "GET",
		url : "../api/surveyor-assign.php",
		data : "q=unSurveyorRejectJob&jobNoNew=" + jobNoNew+"&survId=" + survId,
		dataType : "json",
		success : function(msg) {
			$('#row_'+jobNoNew).show();
			showTips( "撤銷操作成功.", 35, 60 );
		}
	});
}