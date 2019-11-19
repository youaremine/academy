<?php
/*
 * Header: Create: 2008-3-13 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

//
$error = '';
$userName = '';
if ($_POST ['login'] != "") {
	// print $_SESSION['antispamChars']." == ".strtolower($_POST['antispam']);
	$userName = $_POST ['userName'];
	$passWord = $_POST ['passWord'];
	$login = new UserLogin ( $db );
	if ($login->Login ( $userName, $passWord )) {
		header ( "Location:mobile_appendixd_survey_entry.php" );
		exit ();
	} else {
		$error = "username or password error.";
	}
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "mobile_login.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_var ( 'Error', $error );
$t->set_var ( "userName", $userName );

$t->pparse ( "Output", "HdIndex" );
?>