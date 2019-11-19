<?php
/*
 * Header: Create: 2008-6-2 Auther: Jamblues@gmail.com.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.schedule.inc.php");
include_once ("../library/init.php");
include_once ("../library/PEAR/Net/Mail.php");
include_once ("../library/PEAR/Net/Mail/mime.php");

// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}

if($_POST['send'] == "Send"){
	if(strpos($_POST['sendContent'],"&lt;&lt;receiver&gt;&gt;") === false){
		// 登录人资料
		$user = new Users($db);
		$ul = new UsersList($db);
		$ul->delFlag = 'no';
		$ul->userId = $_SESSION['userId'];
		$rs = $ul->GetListSearch();
		$rsNo = count($rs);
		if($rsNo > 0){
			$user = $rs[0];
		}
		// 邮件资料
		// print_r($_POST);exit();
		$smh = new SendMailHistory();
		$smh->keyId = $_POST['refNo'];
		$shortRefNo = $_POST['shortRefNo'];
		// print 'smh->keyId:'.$smh->keyId;
		$smh->senderUserId = $user->userId;
		$smh->senderName = $user->engName;
		$smh->senderMail = $user->eMail;
		$smh->sendType = 'report';
		$smh->receiverUserId = "";
		$smh->receiverName = "";
		$smh->receiverMail = $to = $_POST['receiverMailAddr'];
		$cc = $_POST['CCMailAddr'];
		$smh->sendSubject = $subj = $_POST['sendSubject'];
		$smh->sendContent = $body = str_replace("&nbsp;"," ",$_POST['sendContent']);
		$smh->sendTime = date($conf['dateTime']['format']);
		
		// // //发送邮件
		// $smtpserver = "smtp.mail.yahoo.com.hk"; //您的smtp服务器的地址
		// $port = 25 ; //smtp服务器的端口，一般是 25
		// $smtpuser = "ozzotec@yahoo.com.hk"; //您登录smtp服务器的用户名
		// $smtppwd = "0000000000000000"; //您登录smtp服务器的密码
		// $mailtype = "HTML"; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件
		// $sender = "ozzotec@yahoo.com.hk"; //发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败
		
		// //发送邮件
		// $smtpserver = "mail.ozzotec.com"; //您的smtp服务器的地址
		// $port = 25 ; //smtp服务器的端口，一般是 25
		// $smtpuser = "james@ozzotec.com"; //您登录smtp服务器的用户名
		// $smtppwd = "itjames"; //您登录smtp服务器的密码
		// $mailtype = "HTML"; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件
		// $sender = "info@ozzotec.com"; //发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败
		
		$param['html_charset'] = 'utf-8';
		$param['head_charset'] = 'utf-8';
		
		$headers['From'] = 'info@ozzotec.com';
		$headers['To'] = $to;
		$headers['CC'] = $cc;
		$headers['Subject'] = $subj;
		$headers['Content-Type'] = 'text/html';
		$headers['head_charset'] = 'utf-8';
		
		$recipients = $to . "," . $cc;
		
		$params['host'] = 'ssl://smtp.exmail.qq.com';
		$params['port'] = 465;
		$params['username'] = 'info@ozzotec.com';
		$params['password'] = '6URix3LA';
		$params['auth'] = 'LOGIN';
		
		$mime = new Mail_mime();
		$mime->setHTMLBody($body);
		$rawDataFile = $_POST['rawDataFile'];
		$requestFormFile = $_POST['requestFormFile'];
		$reportFile = $_POST['reportFile'];
		$summaryTableFile = $_POST['summaryTableFile'];
		$mime->addAttachment($requestFormFile,"application/octet-stream",$shortRefNo."_request_form." . FileExt($requestFormFile));
		if(! empty($rawDataFile)){
			$mime->addAttachment($rawDataFile,"application/octet-stream",$shortRefNo."_raw_data." . FileExt($rawDataFile));
		}
		$mime->addAttachment($reportFile,"application/octet-stream",$shortRefNo."_report." . FileExt($reportFile));
		$mime->addAttachment($summaryTableFile,"application/octet-stream",$shortRefNo."_summary_table." . FileExt($summaryTableFile));
		
		$body = $mime->get($param);
		$headers = $mime->headers($headers);
		// print $body; exit();
		// Create the mail object using the Mail::factory method
		$smtp = & Mail::factory('smtp',$params);
		//$smtp->debug = true;
		//$smtp->auth($params['username'], $params['password'] , $params['auth'], true, $authz = '');
		$send = $smtp->send($recipients,$headers,$body);
		if(PEAR::isError($send)){
			echo ($send->getMessage());
			exit();
		}else{
			// 将记录写到数据库
			$smha = new SendMailHistoryAccess($db);
			$smh->semhId = $smha->Add($smh);
			// 保存提交报告日期
			$msrd = new MainScheduleReportDate();
			$msrda = new MainScheduleReportDateAccess($db);
			$msrd->jobNo = $_POST['refNo'];
			$msrd->isFirst = '';
			$rs = $msrda->GetListSearch($msrd);
			if(count($rs) > 0)
				$msrd->isFirst = 'no';
			else
				$msrd->isFirst = 'yes';
			$msrd->reportDate = date($conf['date']['format']);
			$msrd->userType = "ReportSend";
			$msrd->inputUserId = $_SESSION['userId'];
			$msrd->inputTime = date($conf['dateTime']['format']);
			$msrda->Add($msrd);
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="./css/css.css" />
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="550" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a
						href="main_schedule_report_send_attachment.php?refNo=<?php echo $_POST['refNo'];?>">重新编辑当前邮件,请点击这里.(Re
						Edit current eamil,please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="main_schedule_report_list.php">瀏覽列表,请点击这里.(To browse
						data List, please click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>
<?php
			exit();
		}
	}else{
		echo "<span style='color:red'>please change the receiver and mail body.</span><a href='main_schedule_report_send_attachment.php?refNo={$_POST['refNo']}'>click here</a> to return.";
	}
	// header("Location:main_schedule_report_send.php?refNo=".$_POST['refNo']);
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex","main_schedule_report_send_attachment.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex","Row","Rows");
$t->set_var("Rows","");
$refNo = $_GET['refNo'];
if(empty($refNo))
	print "refNo is null.";
//$shortRefNo = toShortRefNo($refNo);
$shortRefNo = $refNo;

$msrf = new MainScheduleReportFile();
$msrfa = new MainScheduleReportFileAccess($db);
$msrf->jobNo = $refNo;

$msrf->fileType = 'rawData';
$rsFile = $msrfa->GetListSearch($msrf);
$rsFileNo = count($rsFile);
if($rsFileNo > 0){
	$msrfe = $rsFile[0];
	$rawDataFile = str_replace("./","",$msrfe->fileName);
}

$msrf->fileType = 'requestForm';
$rsFile = $msrfa->GetListSearch($msrf);
$rsFileNo = count($rsFile);
if($rsFileNo > 0){
	$msrfe = $rsFile[0];
	$requestFormFile = str_replace("./","",$msrfe->fileName);
	// $requestFormFile = rawurlencode($requestFormFile);
	// $requestFormFile = str_replace("%2F","/",$requestFormFile);
}
$msrf->fileType = 'report';
$rsFile = $msrfa->GetListSearch($msrf);
$rsFileNo = count($rsFile);
if($rsFileNo > 0){
	$msrfe = $rsFile[0];
	$reportFile = str_replace("./","",$msrfe->fileName);
	// $reportFile = rawurlencode($reportFile);
	// $reportFile = str_replace("%2F","/",$reportFile);
}
$msrf->fileType = 'summaryTable';
$rsFile = $msrfa->GetListSearch($msrf);
$rsFileNo = count($rsFile);
if($rsFileNo > 0){
	$msrfe = $rsFile[0];
	$summaryTableFile = str_replace("./","",$msrfe->fileName);
	// $summaryTableFile = rawurlencode($summaryTableFile);
	// $summaryTableFile = str_replace("%2F","/",$summaryTableFile);
}

// 登录人资料
$user = new Users($db);
$ul = new UsersList($db);
$ul->delFlag = 'no';
$ul->userId = $_SESSION['userId'];
$rs = $ul->GetListSearch();
$rsNo = count($rs);
if($rsNo > 0){
	$user = $rs[0];
}

$isDisabled = 'disabled="disabled"';
$isDisabledError = "you're email is empty.";
if($user->eMail != ''){
	$isDisabled = '';
	$isDisabledError = '';
}
// 得到关于main schedule资料
$ms = new MainSchedule();
$msa = new MainScheduleAccess($db);
$ms->jobNo = $msrf->jobNo;
$rs = $msa->GetListSearch($ms);
$rsNo = count($rs);
$routeItems = "";
$surveyType = "";
$tdNo = "";
$tdYear = "";
for($i = 0;$i < $rsNo;$i ++){
	$ms = $rs[$i];
	$tdNo = $conf['tdNo'][$ms->complateJobNo];
	$tdYear = $conf['tdYear'][$ms->complateJobNo];
	$surveyType = $ms->surveyType;
	if($i == 0){
		$routeItems .= $ms->routeItems;
	}else{
		// 如果时间段已经存在，就不串进来
		$pos = strpos($routeItems,$ms->routeItems);
		if($pos === false){
			$routeItems .= ', ' . $ms->routeItems;
		}
	}
}

$tdNo = $tdNo . "/" . $tdYear;
$webSite = "http://www.ozzotec.com/survey-2013/";
// $webSite = "http://localhost:8080/sourcecode/survey2008/";
$sendContent = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>";
$sendContent = "Dear &lt;&lt;receiver&gt;&gt;, <br /><br />";
$sendContent .= "Attached please find the report of " . $shortRefNo . ", <br />";
$sendContent .= $surveyType . " on " . $routeItems . ". <br /><br />";
// $sendContent .= "Request Form: <strong>"."request_form.".FileExt($requestFormFile)."</strong><br /><br />";
// if(!empty($rawDataFile))
// {
// $sendContent .= "Raw Data: <strong>"."raw_data.".FileExt($rawDataFile)."</strong><br /><br />";
// }
// $sendContent .= "Report: <strong>"."report.".FileExt($reportFile)."</strong><br /><br />";
// $sendContent .= "Summary Table: <strong>"."summary_table.".FileExt($summaryTableFile)."</strong><br /><br />";
$sendContent .= "Thank you for your attention! <br /><br /><br />";
$sendContent .= "Regards, <br />";
$sendContent .= $user->engName . " <br /><br /><br />";
$sendContent .= "This is an auto-reply by system, please do not reply this email directly." . " <br /><br /><br />";
$sendContent .= "</body></html>";
$reportReciver = getArray('report-reciver');
$reportReciver = $reportReciver[$ms->complateJobNo];
$receiverMailAddr = $reportReciver['TO'];
$CCMailAddr = "molly@ozzotec.com, panda@ozzotec.com, karis@ozzotec.com, rosa@ozzotec.com";
if(! empty($user->eMail) && strpos($CCMailAddr,$user->eMail) === false){
	$CCMailAddr = $user->eMail . ", " . $CCMailAddr;
}
if(! empty($reportReciver['CC'])){
	$CCMailAddr = $reportReciver['CC'] . ", " . $CCMailAddr;
}

// 检查文件是否存在
$requestFormFileName = $requestFormFile;
if(! file_exists($requestFormFile))
	$requestFormFileName = '<span style="color:#FF0000;">' . $requestFormFile . "</span>";

$rawDataFileName = $rawDataFile;
if(! file_exists($rawDataFile))
	$rawDataFileName = '<span style="color:#FF0000;">' . $rawDataFile . "</span>";

$reportFileName = $reportFile;
if(! file_exists($reportFile))
	$reportFileName = '<span style="color:#FF0000;">' . $reportFile . "</span>";

$summaryTableFileName = $summaryTableFile;
if(! file_exists($summaryTableFile))
	$summaryTableFileName = '<span style="color:#FF0000;">' . $summaryTableFile . "</span>";
$t->set_var(array (
		"refNo" => $refNo,
		"shortRefNo" => $shortRefNo,
		"txtSenderMailAddr" => $user->eMail,
		"txtReceiverMailAddr" => $receiverMailAddr,
		"txtCCMailAddr" => $CCMailAddr,
		"txtSendSubject" => $tdNo . ": Report of " . $shortRefNo . " (" . $routeItems . ")",
		"txtSendContent" => $sendContent,
		"requestFormFile" => $requestFormFile,
		"rawDataFile" => $rawDataFile,
		"reportFile" => $reportFile,
		"summaryTableFile" => $summaryTableFile,
		"requestFormFileName" => $requestFormFileName,
		"rawDataFileName" => $rawDataFileName,
		"reportFileName" => $reportFileName,
		"summaryTableFileName" => $summaryTableFileName,
		"isDisabled" => $isDisabled,
		"isDisabledError" => $isDisabledError 
));

// 历史部分
$smh = new SendMailHistory();
$smha = new SendMailHistoryAccess($db);
$smh->keyId = $refNo;
$smh->order = " ORDER BY sendTime DESC";
$rs = $smha->GetListSearch($smh);
$rsNo = count($rs);
for($i = 0;$i < $rsNo;$i ++){
	if($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$smh = $rs[$i];
	$t->set_var(array (
			"listStyle" => $listStyle,
			"keyId" => $smh->keyId,
			"senderName" => $smh->senderName,
			"senderMail" => $smh->senderMail,
			"receiverName" => $smh->receiverName,
			"receiverMail" => $smh->receiverMail,
			"sendSubject" => $smh->sendSubject,
			"sendTime" => $smh->sendTime 
	));
	$t->parse("Rows","Row",true);
}
$t->pparse("Output","HdIndex");
?>