<?php
/*
 * Header: 
 * Create: 2007-6-23 
 * Auther: Jamblues.
 */
include_once("./includes/config.inc.php");
// 检查是否登录
if (!UserLogin::IsLogin()) {
    header("Location:login.php");
    exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Default Left</title>
    <link href="css/css.css" type="text/css" rel="stylesheet"/>
    <script language="javascript" src="js/prototype.js"></script>
    <script type="text/javascript">
        <!--
        function ShowRow(NowIndex) {
            var AllCount = 13;
            var WhatTr;
            WhatTr = eval("document.getElementById('Tr" + NowIndex + "')");
            if (WhatTr.style.display == "none") {
                WhatTr.style.display = "";
            }
            else {
                WhatTr.style.display = "none";
            }

            for (i = 1; i <= AllCount; i++) {
                if (i != NowIndex) {
                    var OthTr;
                    OthTr = eval("document.getElementById('Tr" + i + "')");
                    if (OthTr != null) {
                        OthTr.style.display = "none";
                    }
                }
            }
        }

        function CheckIsLogin() {
            var url = 'is_login.php';
            var pars = '';
            var myAjax = new Ajax.Request(
                url,
                {
                    method: 'get',
                    parameters: pars,
                    onComplete: InitIsLogin
                });
        }

        function InitIsLogin(originalRequest) {
            var isExist = originalRequest.responseText;
            if (isExist == 'successful') {
                return true;
            }
            else {
                return false;
            }
        }
        //-->
    </script>
</head>
<body>
<table id="TableFunction" height="100%" cellSpacing="0" cellPadding="0"
       width="100%" border="0">
    <tr>
        <td vAlign="top">
            <table style="width: 184px; height: 27px;"
                   border="0" align="center" cellPadding="0" cellSpacing="0">
                <?php
                if (UserLogin::HasOnePermission(array('main_schedule_unfinished_list', 'progress_view', 'up_to_date_bar_chart_view', 'different_surveyor_list', 'main_schedule_different_planned_date_list', 'main_schedule_list', 'main_schedule_report_list', 'main_schedule_rawfile_list','self_select_list','data_list'))) {

                    ?>
                    <tr onClick="ShowRow(1)">
                        <td class="TdButtonF"><span class="TdButtonFText">主列表</span></td>
                    </tr>
                    <tr id="Tr1" style="display: none">
                        <td>
                            <table cellSpacing="0" cellPadding="0" align="right"
                                   border="0" style="width: 179px">


                                <?php
                                if (UserLogin::HasPermission('bar_chart_time_user')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC">
                                            <a href="chart/bar_chart_time_user.php" target="mainFrame">
                                                <span class="TdButtonCText">課堂學員統計</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                               <!-- <?php
/*                                if (UserLogin::HasPermission('different_surveyor_list')) {
                                    */?>
                                    <tr>
                                        <td class="TdButtonC"><a href="self_select_list.php" target="mainFrame">
                                                <span class="TdButtonCText">自選日程</span></a></td>
                                    </tr>
                                    --><?php
/*                                }
                                */?>
                                <?php
                                if (UserLogin::HasPermission('main_schedule_list')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC"><a href="main_schedule_list.php"
                                                                 target="mainFrame"><span class="TdButtonCText">課程列表</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if (UserLogin::HasPermission('data_list')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC"><a href="data_list.php"
                                                                 target="mainFrame"><span class="TdButtonCText">已點名學員列表</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (UserLogin::HasOnePermission(array('user_entry', 'user_list', 'user_history_list', 'user_role_list'))) {
                    ?>
                    <tr onClick="ShowRow(7)">
                        <td class="TdButtonF"><span class="TdButtonFText">帳戶管理</span></td>
                    </tr>
                    <tr id="Tr7" style="display: none">
                        <td>
                            <table cellSpacing="0" cellPadding="0" align="right"
                                   border="0" style="width: 179px">
                                <?php
                                if (UserLogin::HasPermission('user_entry')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC">
                                            <a href="user_entry.php" target="mainFrame"><span class="TdButtonCText">新增帳戶</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if (UserLogin::HasPermission('user_list')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC">
                                            <a href="user_list.php" target="mainFrame"><span class="TdButtonCText">帳戶列表</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <?php
                                if (UserLogin::HasPermission('user_role_list')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC">
                                            <a href="user_role_list.php" target="mainFrame"><span class="TdButtonCText">帳戶角色</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (UserLogin::HasOnePermission(array('surveyor_entry', 'surveyor_list', 'surveyor_list_schedule', 'surveyor_time_list'))) {
                    ?>
                    <tr onClick="ShowRow(8)">
                        <td class="TdButtonF"><span class="TdButtonFText">學員管理</span></td>
                    </tr>
                    <tr id="Tr8" style="display: none">
                        <td>
                            <table cellSpacing="0" cellPadding="0" align="right"
                                   border="0" style="width: 179px">
                                <?php
                                if (UserLogin::HasPermission('surveyor_entry')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC">
                                            <a href="surveyor_entry.php" target="mainFrame">
                                                <span class="TdButtonCText">新增學員</span></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if (UserLogin::HasPermission('surveyor_list')) {
                                    ?>
                                    <tr>
                                        <td class="TdButtonC">
                                            <a href="surveyor_list.php" target="mainFrame">
                                                <span class="TdButtonCText">學員列表</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </table>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td class="TdButtonF"><a href="logout.php" id="logoutBtn" target="mainFrame"><span
                                class="TdButtonFText">登出</span></a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<script language="javascript" type="text/javascript">
    function myTimer() {
        CheckIsLogin();
        window.setTimeout("myTimer()", 120000);
    }

    myTimer();

</script>
</body>
</html>
<script>
    document.getElementById('logoutBtn').onclick = function(){
        FB.logout(function(response) {
            console.log(response);
            // user is now logged out
        });
        /*FB.getLoginStatus(function (response) {
            console.log('inside login status');
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;

                FB.logout(function (response) {
                    console.log(response);
                    //FB.Auth.setAuthResponse(null, 'unknown');

                });
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app

            } else {
                // the user isn't logged in to Facebook.
                console.log('response status not logged in');
            }
        });*/
    };

</script>
