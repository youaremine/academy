<?php
/*
 * Header: Create: 2007-2-13 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

if ($_POST ['userName'] != "") {
	$user = new Users ( $db );
	$validLoginTime = $_POST ['validLoginTimeYear'] . '-' . $_POST ['validLoginTimeMonth'] . '-' . $_POST ['validLoginTimeDay'] . ' ';
	$validLoginTime .= $_POST ['validLoginTimeHour'] . ':' . $_POST ['validLoginTimeMinute'] . ':' . $_POST ['validLoginTimeSecond'];
	$user->userName = $_POST ['userName'];
	$user->passWord = $_POST ['password'];
	$user->engName = $_POST ['engName'];
	$user->chiName = $_POST ['chiName'];
	$user->sex = $_POST ['sex'];
	$user->moblie = $_POST ['moblie'];
	$user->telephone = $_POST ['telephone'];
	$user->eMail = $_POST ['eMail'];
	$user->validLoginTime = $validLoginTime;
	$user->userHome = $_POST ['userHome'];
	$user->doDistrict = "1";
	foreach ( $conf ['shortDistrictName'] as $k => $v ) {
		$key = "chkDoDistrict{$k}";
		if (! empty ( $_POST [$key] ))
			$user->doDistrict .= "," . $_POST [$key];
	}
	$user->dipaId = $_POST ['dipaId'];
	$user->userRemark = $_POST ['userRemark'];
	$user->doCompany = $_POST ['company'];
	$userId = $user->save ();
	
	$ur = new UserRole ();
	$ura = new UserRoleAccess ( $db );
	$ur->userId = $userId;
	$ur->roleId = $_POST ['roleId'];
	$ura->Add ( $ur );
}

header ( "Location:user_list.php" );
?>