<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 如果是管理员，则不需要验证
if (UserLogin::IsAdministrator ()) {
	if (! empty ( $_GET ['surveyorId'] )) {
		$surveyorCode = $_GET ['surveyorId'];
	} else {
		header ( "Location:login.php" );
		exit ();
	}
} else {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "surveyor_reset_password.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );

// 重置
$message = "";
if (! empty ( $_POST ['submit'] )) {
	$sl = new SurveyorLogin ( $db );
	$sl->ResetPassword ( $surveyorCode );
	$message = "Reset password is successed.";
}

// var_dump($_SERVER);
$loginUrl = "http://{$_SERVER["HTTP_HOST"]}{$_SERVER["PHP_SELF"]}/surveyor_login.php";
$loginUrl = str_replace ( "surveyor_reset_password.php/", "", $loginUrl );
$t->set_var ( "loginUrl", $loginUrl );

// 调查员基本信息
$sur = new Surveyor ();
$sur->survId = $surveyorCode;
$sur->status = '';
$sur->company = '';
$sa = new SurveyorAccess ( $db );
$rs = $sa->GetListSearch ( $sur );
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$sur = $rs [0];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode,
			"message" => $message 
	) );
	if ($sa->IsUpdatedPassword ( $surveyorCode )) {
		$tips = "該用戶已修改過密碼.如忘記,請重置!";
		$password = "無法查看修改過的密碼";
		$disabled = "";
	} else {
        $sur->passWord = substr(substr($sur->contact,0,4)*666,0,3);
		/*if (($sur->survId) % 2 == 0) {
			$sur->passWord = $sur->contact + $sur->survId * substr ( $sur->survId, - 1 );
		} else {
			$sur->passWord = $sur->contact - $sur->survId * substr ( $sur->survId, - 1 );
		}*/
		if($sur->survType == "surveyor")
		{
			$tips = "該用戶使用原始密碼: {$sur->passWord}";
			$password = $sur->passWord;
			$disabled = "disabled='disabled'";			
		}
		else if (UserLogin::HasPermission('worker_salary'))
		{
			$tips = "該用戶使用原始密碼: {$sur->passWord}";
			$password = $sur->passWord;
			$disabled = "disabled='disabled'";
		}
		else 
		{
			$tips = "該用戶使用原始密碼,該密碼已隱藏,請聯繫IT部同事!";
			$password = "已隱藏";
			$disabled = "disabled='disabled'";
		}
	}
	$t->set_var ( array (
			"tips" => $tips,
			"password" => $password,
			"disabled" => $disabled 
	) );
}

$t->pparse ( "Output", "HdIndex" );
?>