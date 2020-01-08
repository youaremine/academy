<?php

include_once ("includes/config.inc.php");
include_once ("includes/config.plugin.inc.php");

$file1=$_FILES['file1'];
$file2=$_FILES['file2'];
$file3=$_FILES['file3'];
$file4=$_FILES['file4'];
$file5=$_FILES['file5'];
$file6=$_FILES['file6'];

$ja = new JobsAccess($db);
$time=time();
if (!empty($file1)){
    $arr=writeFile('640*960(2:3)',$file1,$time,'640*960','2:3');
    if($arr['staus']){
        $ja->advImage(1,$arr);
    }
}
if (!empty($file2)){
    writeFile('1440*2560(9:16)',$file2,$time,'1440*2560','9:16');
}
if (!empty($file3)){
    writeFile('1080*2160(1:2)',$file3,$time,'1080*2160','1:2');
}
if (!empty($file4)){
    writeFile('1242*2688(5:11)',$file4,$time,'1242*2688','5:11');
}
if (!empty($file5)){
    writeFile('1080*1776(3:5)',$file5,$time,'1080*1776','3:5');
}
if (!empty($file6)){
    writeFile('1080*2040*(9:17)',$file6,'1080*2040','9:17');
}


function writeFile($path,$file,$time,$resolution,$rate){
        if(!is_dir('cache/adpic/size/'.$path.'/')){
            if(mkdir('cache/adpic/size/'.$path,0777)){
                $file_suffix=substr($file['name'],-4);
                $paths='cache/adpic/size/'.$path.'/'.$time.$file_suffix;
                move_uploaded_file($file['tmp_name'],$paths);
                $arr=array(
                    'staus'=>true,
                    'path'=>$paths,
                    'file_name'=>$time.$file_suffix,
                    'resolution'=>$resolution,
                    'rate'=>$rate
                );
                return $arr;
            }else{
                $arr=array(
                    'staus'=>false,
                    'path'=>'',
                    'file_name'=>'',
                    'resolution'=>'',
                    'rate'=>''
                );
                return $arr;
            }
        }else{
            $file_suffix=substr($file['name'],-4);
            $paths='cache/adpic/size/'.$path.'/'.$time.$file_suffix;
            move_uploaded_file($file['tmp_name'],$paths);
            $arr=array(
                'staus'=>true,
                'path'=>$paths,
                'file_name'=>$time.$file_suffix,
                'resolution'=>$resolution,
                'rate'=>$rate
            );
            return $arr;
        }
}