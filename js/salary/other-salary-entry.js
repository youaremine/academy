function CheckForm()
{
	$('#myForm').submit();
}

//所有內容均匹配
function AllAsThis()
{
	for(var i=0; i<=allRowNo; i++)
	{
		if(document.getElementById('surveyDate['+i+']').disabled)
		{
			//不更改资料		
		}
		else
		{
			document.getElementById('isUpdate['+i+']').value = 1;
			document.getElementById('surveyorId['+i+']').value = document.getElementById('sSurveyorId').value;
			document.getElementById('surveyorEngName['+i+']').value = document.getElementById('sSurveyorEngName').value;
			document.getElementById('surveyDate['+i+']').value = document.getElementById('sSurveyDate').value;
			document.getElementById('projectCode['+i+']').value = document.getElementById('sProjectCode').value;
			document.getElementById('projectName['+i+']').value = document.getElementById('sProjectName').value;		
		}
	}
}

//添加一行
function AddRow()
{ 
	//TODO
}

//添加指定行數
function AddRowByNo(addNo)
{
	for($i=0;$i<addNo;$i++)
	{
		AddRow();
	}
}

//刪除時改變背景顏色
function ChangeDelete(rowNo)
{
	var isDelete = 'isDelete['+rowNo+']';
	var trId = 'tr['+rowNo+']';
	var delFlag = 'delFlag['+rowNo+']';
	if(document.getElementById(isDelete).checked == true)
	{
		document.getElementById(trId).style.background = '#FF0000';
		document.getElementById(delFlag).value = 'yes';
	}
	else
	{
		document.getElementById(trId).style.background = '';
		document.getElementById(delFlag).value = 'no';
	}
}

//計算總數
function CalcTotal(rowNo)
{
	var wages = document.getElementById("wages["+ rowNo +"]").value;
	var transportExpenses = document.getElementById("transportExpenses["+ rowNo +"]").value;
	if(wages!='' && transportExpenses!='')
	{
		var total = parseFloat(wages) + parseFloat(transportExpenses);
		document.getElementById("total["+ rowNo +"]").value = total.toFixed(1);
	}
}

//計算工資
function CalcWages(rowNo)
{
	var surveyHour = document.getElementById("surveyHour["+ rowNo +"]").value;
	var hourlyRate = document.getElementById("hourlyRate["+ rowNo +"]").value;
	if(surveyHour!='' && surveyHour!=0 && hourlyRate!='' && hourlyRate!=0)
	{
		var wages = parseFloat(surveyHour) * parseFloat(hourlyRate);
		document.getElementById("wages["+ rowNo +"]").value = wages.toFixed(1);
	}
	//計算總工資
	CalcTotal(rowNo);
}

//計算工时
function CalcHours(rowNo)
{
	var startTime = document.getElementById("startTime["+ rowNo +"]").value;
	var endTime = document.getElementById("endTime["+ rowNo +"]").value;
	if(startTime!='' && endTime!='')
	{
		var minutes = TimeDiff(startTime,endTime);
		if (minutes < 0)
			minutes += 24*60; //如果开始时间小于结束时间,则默认为下一天的小时
		var surveyHour = parseFloat(minutes) / 60;
		var restHour = document.getElementById("restHour["+ rowNo +"]").value;
		surveyHour = surveyHour - parseFloat(restHour);
		document.getElementById("surveyHour["+ rowNo +"]").value = surveyHour.toFixed(1);
		//更新时间总计时间后,要一并更新工资
		CalcWages(rowNo);
	}
}

//判断是否有作更新
function ChangeUpdate(rowNo)
{
	document.getElementById('isUpdate['+rowNo+']').value = 1;
}

//将没有:符号的时间,修复为标准时间;
function FixTime(thisTime)
{
	var timeValue = thisTime.value;
	if(timeValue != "" && timeValue.indexOf(":") == -1)
	{
		if(timeValue.length < 4)
			thisTime.value = timeValue.substr(0,1)+":"+timeValue.substr(1,timeValue.length-1);
		else
			thisTime.value = timeValue.substr(0,2)+":"+timeValue.substr(2,timeValue.length-2);
	}
		
}

/*
 * Header: 
 * Create: 2011-07-30
 * Auther: Jamblues@gmail.com.
 */
 Ext.QuickTips.init();
 Ext.form.Field.prototype.msgTarget = 'side'; 
 function OpenUpload(otId)
 {
 	Ext.onReady(function() {
	    var form = new Ext.form.FormPanel({
	        baseCls: 'x-plain',
	        labelWidth: 80,
	        url:'other-salary-entry_upload_press.php',
			fileUpload:true,
	        defaultType: 'textfield',
	
	        items: [{
	        	xtype: 'hidden',
	            name: 'otId',
	            value: otId
	        },{
	            xtype: 'textfield',
	            fieldLabel: 'File Name',
	            name: 'userfile',
	            inputType: 'file',
	            allowBlank: false,
	            blankText: 'File can\'t not empty.',
	            cls: 'logintext',
	            anchor: '90%'  // anchor width by percentage
	        }]
	    });
	
	    var win = new Ext.Window({
	        title: 'Upload file',
	        width: 400,
	        height:200,
	        minWidth: 300,
	        minHeight: 100,
	        layout: 'fit',
	        plain:true,
	        bodyStyle:'padding:5px;',
	        buttonAlign:'center',
	        items: form,
	
	        buttons: [{
	            text: 'Upload',
	            handler: function() {
	            	if(form.form.isValid()){
		            	Ext.MessageBox.show({
							   title: 'Please wait',
							   msg: 'Uploading...',
							   progressText: '',
							   width:300,
							   progress:true,
							   closable:false,
							   animEl: 'loding'
						   });
				        form.getForm().submit({    
					        success: function(form, action){
					           Ext.Msg.alert('Message',action.result.msg);
					           win.hide();  
					        },    
					       failure: function(){    
					          Ext.Msg.alert('Error', 'File upload failure.');    
					       }
				       	})		       
			   		}
	           }
	        },{
	            text: 'Close',
	            handler:function(){win.hide();}
	        }]
	    });
	 	win.show();
	});;
 }