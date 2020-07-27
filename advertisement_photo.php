<?php

include_once("includes/config.inc.php");
include_once("includes/config.plugin.inc.php");


$inquire = filter_input(INPUT_POST, 'inquire');//初始化查询
$ranking = filter_input(INPUT_POST, 'ranking');//第几张图片
$resolutionArr = filter_input(INPUT_POST, 'resolutionArr');//实际分辨率数组

if (!empty($inquire)) {
    $ja = new JobsAccess($db);
    $arr['ranking'] = $ranking;
    $urlInfo = $ja->advImage(4, $arr);//查询数据库
    if ($urlInfo['status'] == 'success') {
        $urlInfos = ['code' => 1, 'msg' => '查询成功', 'data' => $urlInfo['data']];
        echo json_encode($urlInfos, JSON_UNESCAPED_UNICODE);
    } else if ($urlInfo['status'] == 'failed') {
        $urlInfos = ['code' => 0, 'msg' => '没有数据', 'data' => null];
        echo json_encode($urlInfos, JSON_UNESCAPED_UNICODE);
    }
    exit();
}


if (!empty($resolutionArr)) {
    setcookie("ranking", $ranking, time() + 10);
    setcookie("resolutionArr", $resolutionArr, time() + 10);
    $arr = array(
        'status' => true
    );
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    exit();
}

$file1 = $_FILES['file1'];
$file2 = $_FILES['file2'];
$file3 = $_FILES['file3'];
$file4 = $_FILES['file4'];
$file5 = $_FILES['file5'];
$file6 = $_FILES['file6'];
$fileArr = array($file1, $file2, $file3, $file4, $file5, $file6);

$ja = new JobsAccess($db);
$time = time();
$date = date('Y-m-d H:i:s');
$ranking = $_COOKIE['ranking'];
$resolutionArr = $_COOKIE['resolutionArr'];
$resolutionArr = json_decode($resolutionArr);
batchSave($fileArr, $resolutionArr, $time, $ranking, $date, $ja);

/**将文件放入指定位置，并重命名.进行文件压缩，并转存
 * @param $path 推荐分辨率
 * @param $file 文件流
 * @param $time 时间戳
 * @param $resolution 实际分辨率
 * @param $rate 比率
 * @param $ranking 位置
 * @param $date 上传实际
 * @param $start 是否启用，默认为1
 * @return array
 */
function writeFile($path, $file, $time, $resolution, $rate, $ranking, $date, $start) {
    if (!is_dir('cache/adpic/size/' . $path . '/')) {
        if (mkdir('cache/adpic/size/' . $path, 0777)) {
            $file_suffix = substr($file['name'], -4);
            $paths = 'cache/adpic/size/' . $path . '/' . $time . $file_suffix;
            move_uploaded_file($file['tmp_name'], $paths);//移动文件
            $arr = array(
                'staus' => true,
                'path' => $paths,
                'file_name' => $time . $file_suffix,
                'resolution' => $resolution,
                'rate' => $rate,
                'ranking' => $ranking,
                'upload_time' => $date,
                'start' => $start
            );
            return $arr;
        } else {
            $arr = array(
                'staus' => false,
                'path' => '',
                'condense_path'=>'',
                'file_name' => '',
                'resolution' => '',
                'rate' => '',
                'ranking' => '',
                'upload_time' => '',
                'start' => ''
            );
            return $arr;
        }
    } else {
        $file_suffix = substr($file['name'], -4);
        $paths = 'cache/adpic/size/' . $path . '/' . $time . $file_suffix;//上传文件地址
        move_uploaded_file($file['tmp_name'], $paths);//移动文件到指定地方
        $arr = array(
            'staus' => true,
            'path' => $paths,
            'file_name' => $time . $file_suffix,
            'resolution' => $resolution,
            'rate' => $rate,
            'ranking' => $ranking,
            'upload_time' => $date,
            'start' => $start
        );
        return $arr;
    }
}

/**遍历接收的的文件数据，并进行存储数据库。
 * @param $files 所有接收的文件数据
 * @param $resolutionArr 接收的实际分辨率
 * @param $time 时间
 * @param $ranking 位置
 * @param $date 上传日期
 * @param $ja JobsAccess类对象
 */
function batchSave($files, $resolutionArr, $time, $ranking, $date, $ja) {
    $infoArr = array();
    $len = count($files);
    for ($i = 0; $i < $len; $i++) {
        if (!empty($files[$i])) {
            if ($i == 0) {
                $path = '640*960(2:3)';
                $rate = '2:3';
            } else if ($i == 1) {
                $path = '1440*2560(9:16)';
                $rate = '9:16';
            } else if ($i == 2) {
                $path = '1080*2160(1:2)';
                $rate = '1:2';
            } else if ($i == 3) {
                $path = '1242*2688(5:11)';
                $rate = '5:11';
            } else if ($i == 4) {
                $path = '1080*1776(3:5)';
                $rate = '3:5';
            } else if ($i == 5) {
                $path = '1080*2040(9:17)';
                $rate = '9:17';
            }
            $resolution = $resolutionArr[$i];
            $arr = writeFile($path, $files[$i], $time, $resolution, $rate, $ranking, $date, '1');
            if ($arr['staus']) {
                //压缩文件到指定地方
                $file_suffix = substr($files[$i]['name'], -4);
                $filePath = $arr['path'];//获取文件
                $urlArr = explode('/', $filePath, 5);
                $CfilePath=$urlArr[0].'/'.$urlArr[1].'/condense/'.$arr['resolution'].'_'.$urlArr[4];
                if(!is_dir($urlArr[0].'/'.$urlArr[1].'/condense/')){
                    mkdir($urlArr[0].'/'.$urlArr[1].'/condense', 0777);
                }
                $iden=changeSize($filePath,$CfilePath);
                if($iden){
                    $arr['condense_path']=$CfilePath;
                }
                $judge = $ja->advImage(1, $arr);//写入数据库
                $infoArr[] = $judge;
            }
        }
    }
    echo json_encode($infoArr, JSON_UNESCAPED_UNICODE);
}
/**制作压缩图
 * @param $filePath
 * @param $CfilePath
 * @param int $Condense
 * @return bool
 */
function changeSize($filePath,$CfilePath,$Condense = 12) {
    $size = getimagesize($filePath);//获取文件信息
    $type = $size['mime'];//获取文件后缀
    $typeArr = explode('/', $type, 2);
    $type = $typeArr[1];//获取文件后缀
    $func = 'imagecreatefrom' . $type;//拼接建立原图函数
    $src = $func($filePath);//构建原图
    //取得源图片的宽度和高度
    $w = $size['0'];
    $h = $size['1'];
    //获取缩放宽高
    if($w<700||$h<1000){
        $cw=$w/6;
        $ch=$h/6;
    }else if($w>1500||$h>2500) {
        $cw=$w/16;
        $ch=$h/16;
    }else{
        $cw=$w/$Condense;
        $ch=$h/$Condense;
    }
    //声明一个$w宽，$h高的真彩图片资源，此时只是一个有宽高的黑白图片。
    $image = imagecreatetruecolor($cw, $ch);
    //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）返回值为bool
    imagecopyresampled($image, $src, 0, 0, 0, 0, $cw, $ch, $w, $h);
    $outFunc = 'image' . $type;//拼接输出函数
    $outFunc($image, $CfilePath);//保存图片
    //销毁资源
    imagedestroy($image);
    return true;
}
