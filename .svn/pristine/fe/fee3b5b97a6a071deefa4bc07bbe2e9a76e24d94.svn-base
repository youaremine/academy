<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
// include_once("./includes/config.plugin.inc.php");

// 检查是否登录
if(SurveyorLogin::IsLogin()){
	$surveyorCode = $_SESSION['surveyorId'];
	$noCurrUser = "";
}else if(UserLogin::IsAdministrator() && ! empty($_GET['surveyorId'])){
	$surveyorCode = $_GET['surveyorId'];
	$noCurrUser = "display:none;";
}else{
	header("Location:surveyor_login.php");
	exit();
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex","surveyor_calendar.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex","Row","Rows");
$t->set_block("HdIndex","OtherRow","OtherRows");
$t->set_var("Rows","");
$t->set_var("OtherRows","");
$t->set_block("HdIndex","CalendarCol","CalendarCols");
$t->set_block("HdIndex","CalendarRow","CalendarRows");

// 设置更改密码，登出
$t->set_var("noCurrUser",$noCurrUser);
$t->set_var("surveyorCode",$surveyorCode);

// 调查员基本信息
$sur = new Surveyor();
$sur->survId = $surveyorCode;
$sur->company = '';
$sur->status = '';
$sa = new SurveyorAccess($db);
$rs = $sa->GetListSearch($sur);
$rsNum = count($rs);
if($rsNum > 0){
	$sur = $rs[0];
	$t->set_var(array (
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode 
	));
}

// calendar
$currMonth = date("Y-m");
// $currMonth = "2013-04";
$firstMonthDay = $currMonth . "-01";
$monthMax = date("t",strtotime($firstMonthDay));
$max = 35;
$min = date("N",strtotime($firstMonthDay)) + 1;
$calendars = array ();
for($i = $min;$i <= $max;$i ++){
	$day = $i - $min + 1;
	if($day > $monthMax)
		break;
	$calendars[$i]["day"] = $i - $min + 1;
}
$t->set_var("currMonth",$currMonth);

// 调查员忙碌时间
$sur = new Surveyor();
$sa = new SurveyorAccess($db);
$sur->survId = $surveyorCode;
$monthStartDate = $firstMonthDay;
$monthEndDate = $currMonth . "-" . $monthMax;
$sur->startTime = $firstMonthDay;
$sur->endTime = $monthEndDate . " 23:59:59";
$rs = $sa->GetTimeListSearch($sur);
$rsNum = count($rs);
$surveyorCalendars = array ();
for($i = 0;$i < $rsNum;$i ++){
	$sur = $rs[$i];
	$startTimeStamp = strtotime($sur->startTime);
	$endTimeStamp = strtotime($sur->endTime);
	$tmpDay = date("j",$startTimeStamp);
	if($sur->isFree == "free"){
		$surveyorCalendars[$tmpDay]["free"][] = date("H:i",$startTimeStamp) . " - " . date("H:i",$endTimeStamp);
	}else{
		$surveyorCalendars[$tmpDay]["busy"][] = date("H:i",$startTimeStamp) . " - " . date("H:i",$endTimeStamp);
	}
}
// var_dump($surveyorCalendars);

// $colContentTemplate = "<div style=\"float:left;\"><a id='{day}' href='#freeTimeDialog' rel='leanModal' title='添加空闲时间'><img class='printHide' src='images/assigned_to.png' width='24' border='0' /></a></div>
// <div class=\"Date\" style=\"float:right;\"><font style=\"{dayStyle}\">{day}</font></div>
$colContentTemplate = "<div style=\"float:left;\"><input type='text' name='remarks[{day}]' size='10' placeholder='在此框填寫備註' /></div>
			  <div class=\"Date\" style=\"float:right;\"><font style=\"{dayStyle}\">{day}</font></div>
			  <br clear=\"all\" />
              <input type=\"checkbox\" name=\"unknow[{day}]\" id=\"unknow[{day}]\" value=\"{day}\" {unknowChecked} />
              <label for=\"unknow[{day}]\">未確定</label>
              <br clear=\"all\" />
              <input type=\"checkbox\" name=\"fullBusy[{day}]\" id=\"fullBusy[{day}]\" value=\"{day}\" {fullBusyChecked} />
              <label for=\"fullBusy[{day}]\">全日忙碌</label>
			  <br clear=\"all\" />
              <input type=\"checkbox\" name=\"fullFree[{day}]\" id=\"fullFree[{day}]\" value=\"{day}\" {fullFreeChecked} />
              <label for=\"fullFree[{day}]\">全日得閑</label>
              <br clear=\"all\" />
              <input type=\"checkbox\" name=\"am[{day}]\" id=\"am[{day}]\" value=\"{day}\" {amChecked} />
              <label for=\"am[{day}]\">上午得閑</label>
              <br clear=\"all\" />
              <input type=\"checkbox\" name=\"pm[{day}]\" id=\"pm[{day}]\" value=\"{day}\" {pmChecked} />
              <label for=\"pm[{day}]\">下午得閑</label>
              <br clear=\"all\" />
              <input type=\"checkbox\" name=\"night[{day}]\" id=\"night[{day}]\" value=\"{day}\" {nightChecked} />
              <label for=\"night[{day}]\">晚上得閑</label>
              <br clear=\"all\" />";

for($i = 1;$i <= $max;$i ++){
	$tmpDay = $calendars[$i]["day"];
	$currentDay = date("j");
	if($tmpDay == $currentDay)
		$dayStyle = "color:red;";
	else
		$dayStyle = "";
	$colContent = str_replace("{dayStyle}",$dayStyle,$colContentTemplate);
	
	if(empty($tmpDay)){
		$colBackColor = "background-color:#F0F0F0;";
		$colContent = "";
	}else{
		$colBackColor = "";
		$colContent = str_replace("{day}",$tmpDay,$colContent);
		// 调查员空闲时间
		$fullBusyChecked = "";
		$fullFreeChecked = "";
		$amChecked = "";
		$pmChecked = "";
		$nightChecked = "";
		$unknowChecked = "";
		if(! empty($surveyorCalendars[$tmpDay]["free"])){
			foreach($surveyorCalendars[$tmpDay]["free"] as $k => $v){
				switch($v){
					case "00:00 - 23:59":
						$fullFreeChecked = "checked='checked'";
						break;
					case "06:00 - 12:00":
						$amChecked = "checked='checked'";
						break;
					case "12:00 - 18:00":
						$pmChecked = "checked='checked'";
						break;
					case "18:00 - 23:59":
						$nightChecked = "checked='checked'";
						break;
				}
			}
		}else if(! empty($surveyorCalendars[$tmpDay]["busy"])){
			$fullBusyChecked = "checked='checked'";
		}else{
			$unknowChecked = "checked='checked'";
		}
		$colContent = str_replace("{unknowChecked}",$unknowChecked,$colContent);
		$colContent = str_replace("{fullBusyChecked}",$fullBusyChecked,$colContent);
		$colContent = str_replace("{fullFreeChecked}",$fullFreeChecked,$colContent);
		$colContent = str_replace("{amChecked}",$amChecked,$colContent);
		$colContent = str_replace("{pmChecked}",$pmChecked,$colContent);
		$colContent = str_replace("{nightChecked}",$nightChecked,$colContent);
	}
	
	$t->set_var(array (
			"colBackColor" => $colBackColor,
			"colContent" => $colContent 
	));
	$t->parse("CalendarCols","CalendarCol",true);
	if($i % 7 == 0){
		$t->parse("CalendarRows","CalendarRow",true);
		$t->set_var("CalendarCols");
	}
}

$t->pparse("Output","HdIndex");
?>