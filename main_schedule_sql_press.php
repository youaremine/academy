<?php
include_once('./includes/config.inc.php');

// 以下這段code僅為了刪除無法識別的commplateJobNo
if ($_REQUEST ['q'] == 'delOlder') {
    $newComplateJobNo = '';
    foreach ($conf ['complateJobNo'] as $v) {
        $newComplateJobNo .= ",'" . $v . "'";
    }
    $newComplateJobNo = substr($newComplateJobNo, 1);
    $msa = new MainScheduleAccess ($db);
    $msa->EmptyOlderByComplateJobNo($newComplateJobNo);
    exit ('Delete older is done.');
}
// 检查是否登录
if ($_GET ['sn'] != base64_encode(date("Y-m-d"))) {
    print 'sn is error.';
    exit ();
}
// 上传文件位置
$sqlFile = $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule_sql"];
$sqlFile = str_replace(".sql", "_" . $_GET ["complateJobNo"] . ".sql", $sqlFile);
// print $sqlFile;
// 上传文件最后导入到mysql时间
$importTimeFile = $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule_import_time"];
$lastImportTime = "";
$fp = fopen($importTimeFile, "r");
$lastImportTime = fread($fp, filesize($importTimeFile));
fclose($fp);

// 当前文件修改的时间
$currImportTime = "";
if (file_exists($sqlFile)) {
    $currImportTime = date($conf ['dateTime'] ['format'], filemtime($sqlFile));
} else {
    exit ();
}
$updateNo = 0;
// 判断是否是较新的文件并将数据加入到mysql中
if ($currImportTime > $lastImportTime) {
    $complateJobNo = $_GET ["complateJobNo"];
    $complateJobNo = str_replace(",", "','", $complateJobNo);
    $complateJobNo = "'" . $complateJobNo . "'";
    $msa = new MainScheduleAccess ($db);
    $msa->EmptyTableByComplateJobNo($complateJobNo); // 清空原表格

    $file_handle = fopen($sqlFile, "r");
    while (!feof($file_handle)) {
        $sql = fgets($file_handle);
        if (trim($sql) != "") {
            // print $sql;
            $updateNo++;
            $msa->AddBySql($sql);
        }
    }
    fclose($file_handle);

    // 更改导入的时间
    $handle = fopen($importTimeFile, 'w');
    fwrite($handle, $currImportTime);
    fclose($handle);

    // 更新调查员本月及上月的工作时间
    $sa = new SurveyorAccess ($db);
    $sa->UpdateSurveyorWorkHour();
    // 清空备份表
    $msa->EmptyBackupTableByComplateJobNo($complateJobNo);
    // 复制到备份表
    $msa->CopyBackupTableByComplateJobNo($complateJobNo);
    // 自动识别ss结尾的调查,并更新独立的,Survey_MainSchedulePlannedDate & SurveyorMainSchedule
    //自动将已经改名为SS的job相关的资料一并更改;
    $msa->AutoChangeSSJob($complateJobNo);

    // 更新main schedule的調查时间
    $msa->UpdatePlannedSurveyDate();
    // 更新系統中委派的調查員
    $msa->UpdateAssignedSurveyor();
    // 更新用户自己提交報告的时间
    $msa->UpdateReportDate();
    // 更新原始文件收回(上傳至系統)的時間
    $msa->UpdateReceiveDate();
    //
}
print $updateNo;

?>
