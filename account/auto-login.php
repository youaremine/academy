<?php
/*
 * Header:
 * Create: 2007-1-3
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

// 清除登录信息
unset($_SESSION['surveyorId']);

if ($_REQUEST['username'] != "") {
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$login = new SurveyorLogin($db);
	if ($login->Login($username, $password)) {
	    if($_REQUEST['path'] == 'selectJobs'){
            header('location:jobs_3.php');
        }else{
            header('location:index.php');
        }

	} else {
		header('location:login.php');
	}
}else{
	header('location:login.php');
}
