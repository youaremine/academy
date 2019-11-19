<?php
/*
 * Header: Create: 2007-6-20 Auther: Jamblues.
 */
include_once("./includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin()) {
    header("Location:login.php");
    exit ();
}

$t = new CacheTemplate ("./templates");
$t->set_file("HdIndex", "data_merge_list_add.html");
$t->set_caching($conf ["cache"] ["valid"]);
$t->set_cache_dir($conf ["cache"] ["dir"]);
$t->set_expire_time($conf ["cache"] ["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_var(array("Rows" => ""));

if (!empty ($_POST["Submit"])) {
    $mySupaId = $_POST["supaId"];
    $myRefNo = $_POST["refNo"];
    $myRouteNo = $_POST["routeNo"];
    $mySurveyDate = $_POST["surveyDate"];
    $mySurveyPeriodStart = $_POST["surveyPeriodStart"];
    $mySurveyPeriodEnd = $_POST["surveyPeriodEnd"];
    $myLocation = $_POST["location"];
    $myBounds = $_POST["bounds"];
    $myBusId = $_POST["busId"];
    $mySchNo = $_POST["schNo"];
    $mySchType = $_POST["schType"];
    $myUserName = $_POST["userName"];
    $minSurveyPeriodStart = $mySurveyPeriodStart[0];
    $maxSurveyPeriodEnd = $mySurveyPeriodEnd[0];
    $isValid = true;
    if (count($mySupaId) < 1) {
        $isValid = false;
        print "<script>alert(\"you must select more than two record to merge.\");history.go(-1);</script>";
        exit ();
    }
    for ($i = 1; $i < count($mySupaId); $i++) {
        // print $myRouteNo[$i-1]." ".$myRouteNo[$i] . "<br />" .
        // $mySurveyDate[$i-1]." ".$mySurveyDate[$i] . "<br />" .
        // $myRouteNo[$i-1]." ".$myRouteNo[$i] . "<br />" .
        // $myLocation[$i-1]." ".$myLocation[$i] . "<br />" .
        // $myBounds[$i-1]." ".$myBounds[$i];

        if ($mySurveyDate [$i - 1] == $mySurveyDate [$i] || $myLocation [$i - 1] == $myLocation [$i]) {

            // print $mySurveyPeriodStart[$i].$mySurveyPeriodEnd[$i-1] . "<br />AA " .
            // $mySurveyPeriodStart[$i-1].$mySurveyPeriodEnd[$i];
            $minSurveyPeriodStart = min($mySurveyPeriodStart [$i - 1], $mySurveyPeriodStart [$i]);
            $maxSurveyPeriodEnd = max($mySurveyPeriodEnd [$i - 1], $mySurveyPeriodEnd [$i]);
        } else {
            $isValid = false;
            print "<script>alert(\"SupId(" . $mySupaId[$i] . ") can't merge.\");history.go(-1);</script>";
            exit ();
        }
    }
    // 合并资料
    if ($isValid) {
        // Survey Part
        $sp = new SurveyPart ($db);
        $sp->refNo = $myRefNo[0] . "_merge";
        $surDate = $mySurveyDate[0];
        $sp->surDate = date('Y-m-d', strtotime($surDate));
        $sp->surFromTime = $minSurveyPeriodStart;
        $sp->surToTime = $maxSurveyPeriodEnd;
        $sp->surId = 0;
        $sp->busId = $myBusId[0];
        $sp->routeNo = $myRouteNo[0];
        $sp->location = $myLocation[0];
        $sp->bounds = $myBounds[0];
        $sp->schNo = $mySchNo[0];
        $sp->schType = $mySchType[0];
        // $sp->busId2 = $myBusId[1];
        // $sp->routeNo2 = $myRouteNo[1];
        // $sp->schType2 = $schType[1];
        // $sp->schNo2 = $schType[1];
        $sp->userName = 'Merge:'.$_SESSION['userEngName'];
        $myUserName = array_unique($myUserName);
        $sp->userName .= '<br />Entry:'.implode(',',$myUserName);
        $sp->supaId = $sp->Save();

        if ($sp->supaId > 0) {
            $sd = new SurveyDetail ($db);
            $sd->supaId = $sp->supaId;
            $sd->supaIds = $_SESSION['supaIds'];
            $sd->Merge();
            // 将合并前后对应的资料添加到合并表中
            $spm = new SurveyPartMerge ($db);
            $spm->mergeUserId = $_SESSION['userId'];
            $spm->mergeUserName = $_SESSION['userEngName'];
            $spm->newSupaId = $sp->supaId;
            for ($i = 0; $i < count($mySupaId); $i++) {
                $spm->oldSupaId = $mySupaId [$i];
                $spm->Save();
            }
            // 删除合前的资料
            $sp->supaIds = $_SESSION ['supaIds'];
            $sp->delFlag = 'yes';
            $sp->DelByIds();
            // 删除Session
            unset ($_SESSION ['supaIds']);
            print "<script>alert(\"merge is succeed,new refNo is {$sp->refNo}.\");parent.location='data_list.php?txtRefNo={$myRefNo[0]}';</script>";
            exit ();
        }
    }
}

// 设置要合并的SESSION.
$supaId = $_GET ['supaId'];
if (!empty ($supaId)) {
    $supaIds = $_SESSION ['supaIds'];
    if ($_GET ['act'] == 'Add') {
        if ($supaIds == "") {
            $arrSupaIds = array();
        } else {
            $arrSupaIds = explode(',', $supaIds);
        }
        if (in_array($supaId, $arrSupaIds)) {
            // TODO
        } else {
            array_push($arrSupaIds, $supaId);
            $_SESSION ['supaIds'] = implode(',', $arrSupaIds);
        }
    } else {
        $supaIds = $_SESSION ['supaIds'];
        if (strpos($supaIds, ',')) {
            $supaIds = str_replace(',' . $supaId, '', $supaIds);
            $supaIds = str_replace($supaId . ',', '', $supaIds);
        } else {
            $supaIds = str_replace($supaId, '', $supaIds);
        }
        $_SESSION ['supaIds'] = $supaIds;
    }
}
// $_SESSION['supaIds']="";
if (!empty ($_SESSION ['supaIds'])) {
    $spl = new SurveyPartList ($db);
    $spl->supaIds = $_SESSION ['supaIds'];
    $rs = $spl->GetListSearch();
    $rsNum = count($rs);
    for ($i = 0; $i < $rsNum; $i++) {
        if ($i % 2 == 0) $listStyle = "AlternatingItemStyle"; else
            $listStyle = "DgItemStyle";
        $sp = $rs [$i];
        $t->set_var(array("listStyle" => $listStyle, "supaId" => $sp->supaId, "refNo" => $sp->refNo, "busId" => $sp->busId, "routeNo" => $sp->routeNo, "surveyDate" => $sp->surDate, "surveyPeriod" => $sp->surFromTime . "-" . $sp->surToTime, "surveyPeriodStart" => $sp->surFromTime, "surveyPeriodEnd" => $sp->surToTime, "location" => $sp->location, "bounds" => $sp->bounds, "schNo" => $sp->schNo, "schType" => $sp->schType, "userName" => $sp->userName, "type" => $sp->type));
        $t->parse("Rows", "Row", true);
    }
}

$t->pparse("Output", "HdIndex");
?>