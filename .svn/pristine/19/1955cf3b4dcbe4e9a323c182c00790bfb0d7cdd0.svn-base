<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$project = "survey-2017";
include_once("/home/share/site/survey.ozzomap.com/{$project}-ext/includes/config.inc.php");
include_once("/home/share/site/survey.ozzomap.com/{$project}-ext/includes/config.plugin.inc.php");

$baseDir = "/home/share/site/survey.ozzomap.com/{$project}-ext/pdf/rawdata/";

// 由於做報告的同事會把floder的名字改來改去.
$dirs = array (
    "NTW",
    "KLN",
    "OFC",
    "EP",
    "BR",
    "TAXI",
    "BRB",
    "S"
);
$floders = array();
foreach ($dirs as $v) {
    $handle = opendir($baseDir . $v);
    $i = 0;
    while ($file = readdir($handle)) {
        if (($file != ".") and ($file != "..")) {
            if (is_dir($baseDir . $v . "/" . $file)) {
                $temp = explode("_", $file);
                $jobNo = $temp [0];
                $floders [$v] [$jobNo] = $file;
            }
        }
    }
    closedir($handle);
}

// 檢查服務器上還未完成有收到文件時間的job no.
$apiUrl = "http://www.ozzotec.com/{$project}/api/rawdata.php?q=getNoFinishedRawData";
$json = get_httpfile($apiUrl);
if (function_exists("json_decode")) {
    $data = json_decode($json);
} else {
    $jsonService = new Services_JSON ();
    $data = $jsonService->decode($json);
}

foreach ($data as $v) {
    if ($floders [$v->districtName] [$v->jobNo] == $v->jobNo) continue;
    $fileName = $v->districtName . "/" . $floders [$v->districtName] [$v->jobNo] . "/" . $v->jobNoNew . ".pdf";
    $downloadUrl = "../pdf/rawdata/" . $fileName;
    $fileName = $baseDir . $fileName;
    if (file_exists($fileName)) {
        $createTime = filemtime($fileName);
        $msrf = new MainScheduleRawFile();
        $msrfa = new MainScheduleRawFileAccess($db);
        $msrf->jobNoNew = $v->jobNoNew;
        $msrf->fileType = "rawpdf";
        $rs = $msrfa->GetListSearch($msrf);
        $rsNo = count($rs);
        if ($rsNo > 0) {
            $msrf = $rs [0];
        }
        $msrf->fileName = $downloadUrl;
        // $msrf->modifyTime = date($conf['dateTime']['format'],$createTime);
        // echo "modifyTime:{$msrf->modifyTime}<br />";
        if ($msrf->msrfId <= 0) {
            $msrf->msrfId = $msrfa->Add($msrf);
        } else {
            $msrfa->Update($msrf);
        }
        $isUpdateRomote = $msrfa->UpdateRomoteData($msrf);
        echo $fileName;
        echo "; \$isUpdateRomote:{$isUpdateRomote}<br />\r\n";
    }
}
$db->close();

