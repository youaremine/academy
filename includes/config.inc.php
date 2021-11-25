<?php
/*
 * Header: config all setting in this file.
 * Create: 2009-03-03
 * Auther: Jamblues.
 */
error_reporting(E_ALL & ~E_NOTICE);
define('SITEVESION', 201612142242);
define('PROJECTNAME', 'onfire');
session_start();
header('content-Type: text/html; charset=utf-8');
$conf = array();

//阿里云短信配置
$conf['ali']['ACCESSKEYID'] = "LTAI5tBD6Xq2nvzFojiMcX5s";
$conf['ali']['ACCESSKEYSECRET'] = "6Y3PWhXLoD4q8FYCprO8IymeJRI6kE";
$conf['ali']['signname'] = "奥世傲科技";

$conf['ali']['sign_temp_id_1'] = "SMS_217960674";//國内
$conf['ali']['sign_temp_id_2'] = "SMS_223589257";//國際




// current path
$conf["path"]["root"] = dirname(dirname(__FILE__)) . '/';
$conf["path"]["access"] = $conf["path"]["root"] . "includes/access/";
$conf["path"]["entity"] = $conf["path"]["root"] . "includes/entity/";
$conf["path"]["currDir"] = "./";
$conf["path"]["report"] = "./report/";
$conf["path"]["excel"] = "./excel/";
$conf["path"]["pdf"] = "./pdf/";
$conf["path"]["excelProduct"] = "./excel/product/";
$conf["path"]["inputExcel"] = "./excel/input/";
$conf["path"]["taxiExcel"] = "./excel/taxi/";
$conf["path"]["otherExcel"] = "./excel/other/";
$conf["path"]["schedule"] = "./schedule/";
$conf["path"]["surveyor"] = "./surveyor/";
$conf["path"]["main_schedule"] = "./main_schedule/";
$conf["path"]["flowChartTemplate"] = "./flow/chart-template/";
//$conf["path"]["sign"] = $conf["path"]["root"] ."runtime/sign/";
$conf["path"]["sign"] = $conf["path"]["root"] . "./runtime/sign/";
// file name
// surveyor
$conf["file"]["surveyor"] = "surveyor_list.xls";
$conf["file"]["surveyor_import_time"] = "surveyor_import_time.txt";
// main schedule
$conf["file"]["main_schedule"] = "main_schedule.xls";
$conf["file"]["main_schedule_sql"] = "main_schedule.sql";
$conf["file"]["main_schedule_import_time"] = "main_schedule_import_time.txt";

// config input
$conf['input']['rowNumber'] = 20;
// decimal
$conf['decimal']['precision'] = 1;
// date time format
$conf['date']['format'] = "Y-m-d";
$conf['dateTime']['format'] = 'Y-m-d H:i:s';
$conf['time']['format'] = 'H:i:s';
// survey start date
$conf['survey']['start_date'] = '2016-02-01';
$conf['survey_start_date']['all'] = '2016-02-01';
//港島班
$conf['survey_start_date']['81216'] = '2017-02-27';
$conf['surveytime']['81216'] = 10700;
$conf['feeHour']['81216'] = 109.4;
$conf['tdNo']['81216'] = 'TD229';
$conf['tdYear']['81216'] = '2016';
$conf['districtName']['81216'] = '港島班';
$conf['complateJobNo']['港島班'] = '81216';
$conf['shortDistrictName']['I'] = '港島班';
//九龍A班
$conf['survey_start_date']['81106'] = '2017-02-27';
$conf['surveytime']['81106'] = 10000;
$conf['feeHour']['81106'] = 50;
$conf['tdNo']['81106'] = 'OZ001';
$conf['tdYear']['81106'] = '2017';
$conf['districtName']['81106'] = '九龍A班';
$conf['complateJobNo']['九龍A班'] = '81106';
$conf['shortDistrictName']['K'] = '九龍A班';
//LTW
$conf['survey_start_date']['81214'] = '2017-10-02';
$conf['surveytime']['81214'] = 665;
$conf['feeHour']['81214'] = 120.3;
$conf['tdNo']['81214'] = 'Lutheran TW';
$conf['tdYear']['81214'] = '2017';
$conf['districtName']['81214'] = '新界班';
$conf['complateJobNo']['新界班'] = '81214';
$conf['shortDistrictName']['T'] = '新界班';

// table prefix
$conf['table']['prefix'] = 'Survey_';
// cache time out
$conf["cache"]["valid"] = false; // true:caching; false:not caching
$conf["cache"]["dir"] = $conf["path"]["root"] . "cache/"; // cache dir
$conf["cache"]["timeout"] = 14400; // unit:second
$conf["debug"]["stat"] = false;// is debug
// set bus person number
$conf['bus']['mini']['person'] = 16;
$conf['bus']['coach']['person'] = 28;
$conf['bus']['big']['person'] = 85;

// page set
$conf['page']['stat'] = true;
$conf['page']['pagesize'] = 20;

// database product

$conf["dbConnectStr"]["BusSurvey"]["host"] = "localhost";
$conf["dbConnectStr"]["BusSurvey"]["dataBase"] = "on_fire";
$conf["dbConnectStr"]["BusSurvey"]["user"] = "gogolunadm_alex";
$conf["dbConnectStr"]["BusSurvey"]["password"] = "stanleyalex";
$conf["dbConnectStr"]["BusSurvey"]["characterSet"] = "latin1";


include_once($conf["path"]["root"] . "../library/database/DataBase.php");
include_once($conf["path"]["root"] . "../library/phplib/Template.php");
include_once($conf["path"]["root"] . "../library/phplib/CacheTemplate.php");
include_once($conf["path"]["root"] . "../library/json/json.class.php");
include_once($conf["path"]["root"] . "includes/function.php");

$db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);


function myautoload($name) {
    global $conf;

    try {
        if (strstr(strtolower($name), "pear")) {
            return true;
        }
        if (file_exists($conf["path"]["access"] . $name . '.php')) {
            require_once($conf["path"]["access"] . $name . '.php');
        } else if (file_exists($conf["path"]["entity"] . $name . '.php')) {
            require_once($conf["path"]["entity"] . $name . '.php');
        } else {
            if ($name !== "Redis" || $name !== "MsgPush") {
                if(file_exists($conf["path"]["root"] . "includes/" . $name . '.php')){
                    require_once($conf["path"]["root"] . "includes/" . $name . '.php');
                }

            }
        }

    } catch (Exception $e) {
        var_dump($name);exit;
        // die(); // 终止异常
    }

    return true;
}
/**
 * 自动载入classes
 *
 * @param string $name
 * @return bool
 */
spl_autoload_register("myautoload");

require_once ($conf["path"]["root"] .'vendor/autoload.php');
