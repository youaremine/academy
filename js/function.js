// fix for deprecated method in Chrome 37
  if (!window.showModalDialog) {
     window.showModalDialog = function (arg1, arg2, arg3) {

        var w;
        var h;
        var resizable = "no";
        var scroll = "no";
        var status = "no";

        // get the modal specs
        var mdattrs = arg3.split(";");
        for (i = 0; i < mdattrs.length; i++) {
           var mdattr = mdattrs[i].split(":");

           var n = mdattr[0];
           var v = mdattr[1];
           if (n) { n = n.trim().toLowerCase(); }
           if (v) { v = v.trim().toLowerCase(); }

           if (n == "dialogheight") {
              h = v.replace("px", "");
           } else if (n == "dialogwidth") {
              w = v.replace("px", "");
           } else if (n == "resizable") {
              resizable = v;
           } else if (n == "scroll") {
              scroll = v;
           } else if (n == "status") {
              status = v;
           }
        }
        console.log(arg1);
        var left = window.screenX + (window.outerWidth / 2) - (w / 2);
        var top = window.screenY + (window.outerHeight / 2) - (h / 2);
        var targetWin = window.open(arg1, arg1, 'toolbar=no, location=no, directories=no, status=' + status + ', menubar=no, scrollbars=' + scroll + ', resizable=' + resizable + ', copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        targetWin.focus();
     };
  }
  
//是否是数字
function IsNum(Str)
{
	var i;
	for(i=0;i<Str.length;i++)
	{
		if (((Str.charCodeAt(i)>57) || (Str.charCodeAt(i)<48)))
		{
			return false;
		}
	}
	return true;
}
//去掉空格
function Trim(Str)
{
	while(Str.charCodeAt(0)==32)
	{
		Str=Str.substr(1);
	}
	while (Str.charCodeAt(Str.length-1)==32)
	{
		Str=Str.substr(0,(Str.length-1));
	}
	return Str;
}

//是否是有效时间
function IsTrueTime(thisTime,type)
{
	if(!IsNum(thisTime))
	{
		return false;
	}
	if(type=="hor")
	{
		if(thisTime<0 || thisTime>24)
			return false;
		else
			return true;
	}
	if(type=="min")
	{
		if(thisTime<0 || thisTime>60)
			return false;
		else
			return true;
	}
}

//检查当前时间
function CheckCurrTime(thisControl,thisTime,type,startTime,endTime)
{
	thisTime = parseInt(thisTime,10);
	startTime = parseInt(startTime,10);
	endTime = parseInt(endTime,10);
	if(thisTime<startTime || thisTime>endTime)
	{
		alert(Lang_timeFormatError);
		thisControl.value = '';
		thisControl.focus();
		thisControl.select();
		return false;
	}
	return true;
}

//检查这个时间
function CheckThisTime(thisControl,thisTime,type)
{
	if(!IsTrueTime(thisTime,type))
	{
		alert(Lang_timeFormatError);
		thisControl.focus();
		thisControl.select();
		return false;
	}
	else
	{
		return true;
	}
}

//比较两个控件值的大小
function CompTowControl(control1,control2)
{
	var val1 = control1.value;
	var val2 = control2.value;
	if(val1!="" && val2!="")
	{
		if(val1 >= val2)
			return true;
		else
			return false;
	}
	else
	{
		return false;
	}
}

//比较两个时间大小,返回分钟数
function TimeDiff(startTime,endTime)
{

	var	startTimeMin = ConvertMin(startTime);
	var endTimeMin = ConvertMin(endTime);
	return endTimeMin - startTimeMin;
}

//将时间转化为分钟
function ConvertMin(timeObj)
{ 
	var timeData   =   timeObj.split(":"); 
	var tHour   =   parseInt(timeData[0],10); 
	var tMin   =   parseInt(timeData[1],10); 
	return   tHour*60+tMin; 
} 

//打开模式窗口
function openModalDialog(openUrl, width, height, returnTextIDs)
{
    var retValue = window.showModalDialog(openUrl,'','dialogWidth:'+width+'px;dialogHeight:'+height+'px;status:no;scroll:auto;help:no;');
	//for chrome   
	if (retValue == undefined) {  
		retValue = window.returnValue;  
	}
	 if(retValue != null)
	 {
		 var arrTextBoxIDs = returnTextIDs.split("|");
            var arrReturnValues = retValue.split("|");
            var arrTextBoxIDCount = arrTextBoxIDs.length;
            var arrReturnValueCount = arrReturnValues.length;

            if(arrTextBoxIDCount > 0 && arrReturnValueCount > 0)
            {               
                for(var i = 0; i < arrTextBoxIDCount; i++)
                {
                    try
                    {						
						var oldValue = document.getElementById(arrTextBoxIDs[i]).value;                        
                        if(i == arrTextBoxIDCount - 1)
                        {
                            document.getElementById(arrTextBoxIDs[i]).value = arrReturnValues[i];
                        }
                        else
                        {
                            if(document.getElementById(arrTextBoxIDs[i])!=null)         
							 {
								document.getElementById(arrTextBoxIDs[i]).value = arrReturnValues[i];
							 }
                        }
						if(arrTextBoxIDs[i].substring(0,5) == 'pslNo')//survey_modify.php頁才會用到. add by james 2011-12-07
						{
							if(oldValue != document.getElementById(arrTextBoxIDs[i]).value)
							{
								var row = arrTextBoxIDs[i].match(/\d+/ig)[0];
								document.getElementById("isUpdate["+row+"]").value = 1;
							}
						}
                    }catch(er){}
                }
            }
	 }
    //txtBoxIds.value = retValue;
}

//打开模式窗口
function openMyModalDialog(openUrl, width, height, textID)
{    
	openUrl = openUrl+document.getElementById(textID).value;
    var retValue = window.showModalDialog(openUrl,'','dialogWidth:'+width+'px;dialogHeight:'+height+'px;status:no;scroll:auto;help:no;');
    //txtBoxIds.value = retValue;
}

//打开模式窗口并有返回值
function openCusModalDialog(openUrl, width, height, textID, returnTextIDs)
{
	openUrl = openUrl+document.getElementById(textID).value;
	openModalDialog(openUrl, width, height, returnTextIDs);
}

function SimulateExcel(leftBox,topBox,rightBox,bottomBox,index,keyCode)
{
	var	str = "";
	var input = null;
	switch(keyCode)
	{
		case 13: // 加车
		str = rightBox + "[" + index + "]";
		input = document.getElementById(str);
		if(input != null)
			input.focus();
		break;
		case 37: //向左
		str = leftBox + "[" + index + "]";
		input = document.getElementById(str);
		if(input != null)
			input.focus();
		break;
		case 38: //向上
		index = parseInt(index) - 1;
		str = topBox + "[" + index + "]";
		input = document.getElementById(str);
		if(input != null)
			input.focus();
		break;
		case 39: //向右
		str = rightBox + "[" + index + "]";
		input = document.getElementById(str);
		if(input != null)
			input.focus();
		break;
		case 40: //向下
		index = parseInt(index) + 1;
		str = bottomBox + "[" + index + "]";
		input = document.getElementById(str);
		if(input != null)
			input.focus();
		break;
	}
	
}

//设置背景颜色
var tr_1 = "";
var class_1 = "";
function SelectRow(tr)
{
	if(tr_1 != "")
	{
		tr_1.style.backgroundColor = "";
	}
	tr_1 = tr;
	class_1 = tr.className;
	tr.style.backgroundColor = "#C90";
}

//清除傳過來以 | 隔開的值
function Clear(clearValues)
{
	var arrClearValues = clearValues.split("|");
	for(var i = 0; i<arrClearValues.length; i++)
	{
		document.getElementById(arrClearValues[i]).value = "";
	}
}

//重写四舍五入
Number.prototype.toFixed=function (d) { 
	var s=this+""; 
	if(!d)d=0; 
	if(s.indexOf(".")==-1)s+="."; 
	s+=new Array(d+1).join("0"); 
	if(new RegExp("^(-|\\+)?(\\d+(\\.\\d{0,"+(d+1)+"})?)\\d*$").test(s)){
		var s="0"+RegExp.$2,pm=RegExp.$1,a=RegExp.$3.length,b=true;
		if(a==d+2){
			a=s.match(/\d/g); 
			if(parseInt(a[a.length-1])>4){
				for(var i=a.length-2;i>=0;i--){
					a[i]=parseInt(a[i])+1;
					if(a[i]==10){
						a[i]=0;
						b=i!=1;
					}else break;
				}
			}
			s=a.join("").replace(new RegExp("(\\d+)(\\d{"+d+"})\\d$"),"$1.$2");

		}if(b)s=s.substr(1); 
		return (pm+s).replace(/\.$/,"");
	}return this+"";

};