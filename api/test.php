<?php
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
echo disCellphone($agent);
function disCellphone($agent){
    $agent=strtolower($agent);
    if((strpos($agent,'android'))){
        return 'android';
    }else if(strpos($agent,'ipad') || strpos($agent,'iphone')){
        return 'ios';
    }else{
        return 'pc';
    }
}
