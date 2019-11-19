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
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

if ($_POST ['send'] == "Send") {
	// 登录人资料
	$user = new Users ( $db );
	$ul = new UsersList ( $db );
	$ul->delFlag = 'no';
	$ul->userId = $_SESSION ['userId'];
	$rs = $ul->GetListSearch ();
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$user = $rs [0];
	}
	// 邮件资料
	// print_r($_POST);exit();
	$smh = new SendMailHistory ();
	$smh->keyId = $_POST ['refNo'];
	// print 'smh->keyId:'.$smh->keyId;
	$smh->senderUserId = $user->userId;
	$smh->senderName = $user->engName;
	$smh->senderMail = $user->eMail;
	$smh->sendType = 'report';
	$smh->receiverUserId = "";
	$smh->receiverName = "";
	$smh->receiverMail = $to = $_POST ['receiverMailAddr'];
	$cc = $_POST ['CCMailAddr'];
	$smh->sendSubject = $subj = $_POST ['sendSubject'];
	$smh->sendContent = $body = $_POST ['sendContent'];
	$smh->sendTime = date ( $conf ['dateTime'] ['format'] );
	
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
	
	$headers ['From'] = 'info@ozzotec.com';
	$headers ['To'] = $to;
	$headers ['CC'] = $cc;
	$headers ['Subject'] = $subj;
	$headers ['Content-Type'] = 'text/html';
	
	$recipients = $to . "," . $cc;
	
	$params ['host'] = 'mail.ozzotec.com';
	$params ['port'] = 25;
	$params ['username'] = 'james@ozzotec.com';
	$params ['password'] = 'itjames';
	$params ['auth'] = 'LOGIN';
	
	$mime = new Mail_mime ();
	$mime->setTXTBody ( $body, false );
	$body = $mime->get ();
	// print $body; exit();
	// Create the mail object using the Mail::factory method
	$smtp = & Mail::factory ( 'smtp', $params );
	$smtp->debug = false;
	$smtp->send ( $recipients, $headers, $body );
	if (PEAR::isError ( $smtp )) {
		echo ($smtp->getMessage ());
	} else {
		echo ("send successfully");
		// 将记录写到数据库
		$smha = new SendMailHistoryAccess ();
		$smh->semhId = $smha->Add ( $smh );
		// 保存提交报告日期
		$msrd = new MainScheduleReportDate ();
		$msrda = new MainScheduleReportDateAccess ();
		$msrd->jobNo = $_POST ['refNo'];
		$msrd->reportDate = date ( $conf ['date'] ['format'] );
		$msrd->userType = "ReportSend";
		$msrd->inputUserId = $_SESSION ['userId'];
		$msrd->inputTime = date ( $conf ['dateTime'] ['format'] );
		$msrda->Add ( $msrd );
	}
	
	// header("Location:main_schedule_report_send.php?refNo=".$_POST['refNo']);
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_report_send.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );
$refNo = $_GET ['refNo'];
if (empty ( $refNo ))
	print "refNo is null.";

$msrf = new MainScheduleReportFile ();
$msrfa = new MainScheduleReportFileAccess ( $db );
$msrf->jobNo = $refNo;
$msrf->fileType = 'requestForm';
$rsFile = $msrfa->GetListSearch ( $msrf );
$rsFileNo = count ( $rsFile );
if ($rsFileNo > 0) {
	$msrfe = $rsFile [0];
	$requestFormFile = str_replace ( "./", "", $msrfe->fileName );
	$requestFormFile = rawurlencode ( $requestFormFile );
	$requestFormFile = str_replace ( "%2F", "/", $requestFormFile );
}
$msrf->fileType = 'report';
$rsFile = $msrfa->GetListSearch ( $msrf );
$rsFileNo = count ( $rsFile );
if ($rsFileNo > 0) {
	$msrfe = $rsFile [0];
	$reportFile = str_replace ( "./", "", $msrfe->fileName );
	$reportFile = rawurlencode ( $reportFile );
	$reportFile = str_replace ( "%2F", "/", $reportFile );
}
$msrf->fileType = 'summaryTable';
$rsFile = $msrfa->GetListSearch ( $msrf );
$rsFileNo = count ( $rsFile );
if ($rsFileNo > 0) {
	$msrfe = $rsFile [0];
	$summaryTableFile = str_replace ( "./", "", $msrfe->fileName );
	$summaryTableFile = rawurlencode ( $summaryTableFile );
	$summaryTableFile = str_replace ( "%2F", "/", $summaryTableFile );
}

// 登录人资料
$user = new Users ( $db );
$ul = new UsersList ( $db );
$ul->delFlag = 'no';
$ul->userId = $_SESSION ['userId'];
$rs = $ul->GetListSearch ();
$rsNo = count ( $rs );
if ($rsNo > 0) {
	$user = $rs [0];
}

$isDisabled = 'disabled="disabled"';
$isDisabledError = "you're email is empty.";
if ($user->eMail != '') {
	$isDisabled = '';
	$isDisabledError = '';
}
// 得到关于main schedule资料
$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );
$ms->jobNo = $msrf->jobNo;
$rs = $msa->GetListSearch ( $ms );
$rsNo = count ( $rs );
$routeItems = "";
$surveyType = "";
$tdNo = "";
$tdYear = date ( "Y" );
for($i = 0; $i < $rsNo; $i ++) {
	$ms = $rs [$i];
	$tdNo = $conf ['tdNo'] [$ms->complateJobNo];
	$surveyType = $ms->surveyType;
	if ($ms->plannedSurveyDate != "") {
		$tdYear = date ( "Y", strtotime ( $ms->plannedSurveyDate ) );
	}
	if ($i == 0) {
		$routeItems .= $ms->routeItems;
	} else {
		// 如果时间段已经存在，就不串进来
		$pos = strpos ( $routeItems, $ms->routeItems );
		if ($pos === false) {
			$routeItems .= ', ' . $ms->routeItems;
		}
	}
}

$tdNo = $tdNo . "/" . $tdYear;
$webSite = "http://www.ozzotec.com/survey2009/";
$sendContent = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>";
$sendContent = "Dear &lt;&lt;receiver&gt;&gt;, <br /><br />";
$sendContent .= "Attached please find the report of " . $msrf->jobNo . ", <br />";
$sendContent .= $surveyType . " on " . $routeItems . ". <br /><br />";
$sendContent .= "Request Form: <a href=" . $webSite . $requestFormFile . ">" . $webSite . $requestFormFile . "</a><br /><br />";
$sendContent .= "Report: <a href=" . $webSite . $reportFile . ">" . $webSite . $reportFile . "</a><br /><br />";
$sendContent .= "Summary Table: <a href=" . $webSite . $summaryTableFile . ">" . $webSite . $summaryTableFile . "</a> <br /><br />";
$sendContent .= "Thank you for your attention! <br /><br /><br />";
$sendContent .= "Regards, <br />";
$sendContent .= $user->engName . " <br /><br /><br />";
$sendContent .= "This is an auto-reply by system, please do not reply this email directly." . " <br /><br /><br />";
$sendContent .= "</body></html>";
$CCMailAddr = "simon.cheng@scottwilson.com.hk,henry.lam@scottwilson.com.hk,cheng.kamyuen@scottwilson.com.hk,echo.lu@scottwilson.com.hk,tim.yang@scottwilson.com.hk";
// $sendContent = "only test.";
// $receiverMailAddr = "jamblues@foxmail.com";
// $sendContent = base64_encode($sendContent);
$t->set_var ( array (
		"refNo" => $refNo,
		"txtSenderMailAddr" => $user->eMail,
		"txtReceiverMailAddr" => $receiverMailAddr,
		"txtCCMailAddr" => $CCMailAddr,
		"txtSendSubject" => $tdNo . ": Report of " . $msrf->jobNo . " (" . $routeItems . ")",
		"txtSendContent" => $sendContent,
		"isDisabled" => $isDisabled,
		"isDisabledError" => $isDisabledError 
) );

// 历史部分
$smh = new SendMailHistory ();
$smha = new SendMailHistoryAccess ( $db );
$smh->keyId = $refNo;
$smh->order = " ORDER BY sendTime DESC";
$rs = $smha->GetListSearch ( $smh );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$smh = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"keyId" => $smh->keyId,
			"senderName" => $smh->senderName,
			"senderMail" => $smh->senderMail,
			"receiverName" => $smh->receiverName,
			"receiverMail" => $smh->receiverMail,
			"sendSubject" => $smh->sendSubject,
			"sendTime" => $smh->sendTime 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>