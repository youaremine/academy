<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
function ToShortTime($currTime){
	if(strlen($currTime) >= 5){
		return substr($currTime,0,5);
	}
}

/**
 * 返回短日期格式
 *
 * @param 传入的日期 $currDate        	
 * @return unknown
 */
function ToShortDate($currDate){
	global $conf;
	if($currDate != ""){
		return date($conf['date']['format'],strtotime($currDate));
	}else{
		return "";
	}
}

/**
 * 添加時間
 *
 * @param $currTime 當前時間        	
 * @param $addHour 添加的時間數        	
 */
/**
 * 添加時間
 * @param $currTime
 * @param $addHour
 * @return string
 */
function TimeAddHour($currTime,$addHour){
	$hourPart = substr($currTime,0,2);
	$minutePart = substr($currTime,3,2);
	$hourPart = sprintf("%02d",$hourPart + $addHour);
	return $hourPart . ":" . $minutePart;
}

/**
 * 比較兩個時間差,返回相差分鐘數
 *
 * @param time $currTime        	
 * @param time $nextTime        	
 * @return number
 */
function TimeDiff($currTime,$nextTime){
	$arrayCurrHourPart = explode(':',$currTime);
	$currHourPart = (int)$arrayCurrHourPart[0];
	$currMinutePart = (int)$arrayCurrHourPart[1];
	
	$arrayNextHourPart = explode(':',$nextTime);
	$nextHourPart = (int)$arrayNextHourPart[0];
	$nextMinutePart = (int)$arrayNextHourPart[1];
	$diffTime = 0;
	$diffTime = ($nextHourPart - $currHourPart) * 60;
	$diffTime += $nextMinutePart - $currMinutePart;
	return $diffTime;
}
// $currTime = "7:30";
// $nextTime = "07:07";
// print TimeDiff($currTime,$nextTime);
// exit();
function TimeToMinute($currTime){
	$temp = explode(':',$currTime);
	return $temp[0] * 60 + $temp[1];
}

/**
 * 返回当前时间的小时部分
 *
 * @param unknown_type $currTime        	
 * @return unknown
 */
function GetHourPart($currTime){
	$temp = explode(':',$currTime);
	return $temp[0];
}

/**
 * 返回当前时间的分钟部分
 *
 * @param unknown_type $currTime        	
 * @return unknown
 */
function GetMinutePart($currTime){
	$temp = explode(':',$currTime);
	return $temp[1];
}
function MinuteToTime($minute){
	$hour = (int)($minute / 60);
	$minu = $minute % 60;
	if($minu == 0)
		$minu = '00';
	return $hour . ':' . $minu;
}

/**
 *
 * @access public
 * @param datetime $startTime        	
 * @param datetime $endTime        	
 */
function ToTimePartDynamic($startTime,$endTime,$timeDiff = 30){
	$startTime = TimeToMinute($startTime);
	$endTime = TimeToMinute($endTime);
	for($i = 0;;$i ++){
		$minutes = $startTime + $timeDiff * $i;
		if($minutes >= $endTime)
			break;
		$timePart[] = MinuteToTime($minutes);
	}
	return $timePart;
}

/**
 *
 * @access public
 * @param datetime $startTime
 * @param datetime $endTime
 */
function ToTimePart($startTime,$endTime,$timeDiff = 30){
	$start = (int)(TimeToMinute($startTime) / $timeDiff);
	if(TimeToMinute($endTime) % $timeDiff == 0)
		$end = (int)(TimeToMinute($endTime) / $timeDiff);
	else
		$end = (int)(TimeToMinute($endTime) / $timeDiff) + 1;
	for($i = $start;$i <= $end;$i ++){
		$timePart[] = MinuteToTime($timeDiff * $i);
	}
	return $timePart;
}

/**
 * 去掉数组中得复的元素
 *
 * @param array $array        	
 */
function UniqueArray($array){
	for($i = 0;$i < count($array);$i ++){
		$uArray[$array[$i]] = 1;
	}
	@reset($uArray);
	for($i = 0;$i < count($uArray);$i ++){
		$uniqueArray[] = key($uArray);
		next($uArray);
	}
	return $uniqueArray;
}

/**
 * 判断是否为空的函数
 *
 * @param string $v        	
 */
function DelEmpty($v){
	// 当数组中存在空值，换回false，也就是去掉该数组中的空值
	if($v === ""){
		return false;
	}
	return true;
}

/**
 * 去掉数组中空白的元素
 *
 * @param array $array        	
 */
function DelEmptyArray($array){
	return array_filter($array,"DelEmpty");
}

/**
 * 替换掉一些特殊字符
 *
 * @param string $str        	
 */
function CustomerReplace($str){
	$str = str_replace("/","_",$str);
	$str = str_replace(" ","",$str);
	$str = str_replace("Ⅲ","III",$str);
	$str = str_replace("Ⅱ","II",$str);
	$str = str_replace("Ⅰ","I",$str);
	return $str;
}

// 根据月份返回名字
function ReturnNameByMonth($month){
	switch($month){
		case '1':
			$monthName = "Jan";
			break;
		case '2':
			$monthName = "Feb";
			break;
		case '3':
			$monthName = "Mar";
			break;
		case '4':
			$monthName = "Apr";
			break;
		case '5':
			$monthName = "May";
			break;
		case '6':
			$monthName = "June";
			break;
		case '7':
			$monthName = "July";
			break;
		case '8':
			$monthName = "Aug";
			break;
		case '9':
			$monthName = "Sept";
			break;
		case '10':
			$monthName = "Oct";
			break;
		case '11':
			$monthName = "Nov";
			break;
		case '12':
			$monthName = "Dec";
			break;
	}
	return $monthName;
}

/**
 * 分页设置
 *
 * @param $recordTotal 记录总数        	
 * @param $pagesize 每页显示记录数        	
 * @param $page 当前页码        	
 * @param $queryStr 显示页码        	
 *
 */
function Pagination($recordTotal,$pagesize,$page,$queryStr){
	$allPage = 0;
	$next = 0;
	$prev = 0;
	$startCount = 0;
	$endCount = 0;
	$pageStr = "";
	if(strpos($queryStr,"?") === false){
		$spec = "?";
	}else{
		$spec = "&";
	}
	if($page < 1){
		$page = 1;
	}
	if($pagesize > 0){
		$allPage = ceil($recordTotal / $pagesize);
	}
	if($allPage < 1){
		$allPage = 1;
	}
	$next = $page + 1;
	$prev = $page - 1;
	$startCount = ($page + 5) > $allPage?$allPage - 9:$page - 4; // 中间页起始序号
	                                                                 // 中间页终止序号
	$endCount = $page < 5?10:$page + 5;
	// 为了避免输出的时候产生负数，设置如果小于1就从序号1开始
	if($startCount < 1){
		$startCount = 1;
	}
	// 页码+5的可能性就会产生最终输出序号大于总页码，那么就要将其控制在页码数之内
	if($endCount > $allPage){
		$endCount = $allPage;
	}
	$pageStr .= "共" . $allPage . "頁&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$pageStr .= ($page > 1)?"<a href=\"" . $queryStr . $spec . "page=1\">首頁</a>&nbsp;&nbsp;<a href=\"" . $queryStr . $spec . "page=" . $prev . "\">上一頁</a>":"首頁 上一頁";
	// 中间页处理，这个增加时间复杂度，减小空间复杂度
	for($i = $startCount;$i <= $endCount;$i ++){
		$pageStr .= ($page == $i)?"&nbsp;&nbsp;<font color=\"#ff0000\">" . $i . "</font>":"&nbsp;&nbsp;<a href=\"" . $queryStr . $spec . "page=" . $i . "\">" . $i . "</a>";
	}
	$pageStr .= ($page < $allPage)?"&nbsp;&nbsp;<a href=\"" . $queryStr . $spec . "page=" . $next . "\">下一頁</a>&nbsp;&nbsp;<a href=\"" . $queryStr . $spec . "page=" . $allPage . "\">末頁</a>":" 下一頁  末頁";
	return $pageStr;
}

/**
 * 转换日期格式
 *
 * @param $date 要转换的日期        	
 */
function TransferDateTime($date){
	if(ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$date,$regs)){
		return $regs[3] . "-" . $regs[2] . "-" . $regs[1];
	}else{
		return $date;
	}
}

/**
 * 将Excel时间转换为正常日期
 *
 * @param int $number        	
 * @return 正常日期
 */
function ExcelNumberToDate($number){
	if($number == (int)$number && $number > 25568){
		// 25568代表1900-1970年的天数
		return @date("Y-m-d",mktime(0,0,0,1,($number - 25568),1970));
	}else{
		return "";
	}
}

/**
 * 将正常日期转换为Excel时间
 *
 * @param date $date
 *        	* @return 正常日期
 */
function DateToExcelNumber($date){
	return floor((strtotime($date) - strtotime("1970-01-01")) / (60 * 60 * 24)) + 25568;
}

/**
 * 两个日期相差多少天
 *
 * @param date $dateStart        	
 * @param date $dateEnd        	
 * @return 相差的天数
 */
function DateDiffDay($dateStart,$dateEnd){
	return floor((strtotime($dateEnd) - strtotime($dateStart)) / (60 * 60 * 24));
}

/**
 * 返回两个日期之间的所有日期
 * @param $dateStart
 * @param $dateEnd
 * @return array
 */
function DateDiffRange($dateStart,$dateEnd){
	$dateArr = array();
	$diff = floor((strtotime($dateEnd) - strtotime($dateStart)) / 86400);
	$dateStartTime = strtotime($dateStart);
	for($i=0;$i<=$diff;$i++){
		$dateArr[] = date('Y-m-d',($dateStartTime + $i * 86400));
	}
	return $dateArr;
}

/**
 * 根据短地区代号得到长地区代号
 *
 * @param $shortDistCode 短地区代号        	
 */
function GetFullDistCode($shortDistCode){
	$fullDistCode = $shortDistCode;
	switch($shortDistCode){
		case "H":
			$fullDistCode = "HK";
			break;
		case "K":
			$fullDistCode = "KLN";
			break;
		case "N":
			$fullDistCode = "NT";
			break;
	}
	return $fullDistCode;
}

/**
 * 根据短地区代号得到地区号码
 *
 * @param $shortDistCode 短地区代号        	
 */
function GetFullDistNumber($shortDistCode){
	global $conf;
	$districtName = $conf['shortDistrictName'][$shortDistCode];
	$fullDistNumber = $conf['complateJobNo'][$districtName];
	return $fullDistNumber;
}

/**
 * 取得文件的后缀名
 *
 * @param string $filename        	
 * @return string
 */
function fileext($filename){
	return trim(substr(strrchr($filename,'.'),1,10));
}

/**
 *
 * 与excel中的celing一样用法.
 * 如:3.1->3.5; 3.51->4;
 *
 * @param unknown_type $value        	
 */
function ceiling($value){
	$value = round($value,1);
	$dstValue = ceil($value);
	if(($dstValue - $value) >= 0.5){
		$dstValue -= 0.5;
	}
	return $dstValue;
}

/**
 * 返回文件數組
 *
 * @param string $name        	
 */
function getArray($name){
	global $conf;
	return require $conf["path"]["root"] . "config/" . $name . '.php';
}

/**
 * 將數組寫入到文件
 *
 * @param string $name        	
 * @param array $array        	
 */
function setArray($name,$array){
	global $conf;
	$fp = fopen($conf["path"]["root"] . "config/" . $name . '.php','w');
	fputs($fp,'<?php return ' . var_export($array,true) . '; ?>');
	fclose($fp);
}

/**
 *
 * 將onBoardCostFare根據規則轉成小時數.
 *
 * @param $complateJobNo
 * @param $totalOnBoardCostFare
 * @return string
 */
function CalcOnBoardCostFare2Hour($complateJobNo,$totalOnBoardCostFare){
	global $conf;
	if(intval($conf['feeHour'][$complateJobNo])<=0){
		return 0;
	}
	$costHour = ($totalOnBoardCostFare) / $conf['feeHour'][$complateJobNo];
	$costHour = round($costHour,$conf['decimal']['precision']);
	// round 去 .0 / .5 (NT / NF[T] only)
	if($complateJobNo == $conf['complateJobNo']['NT']){
		$costHour = ceiling($costHour);
	}
	return $costHour;
}

/**
 * 将数组变成sql形式的字符串.
 * Enter description here ...
 *
 * @param $arr
 * @return string
 */
function implodeSqlIn($arr){
	return "'" . implode("','",$arr) . "'";
}

/**
 *
 * 获取指定的工作者
 *
 * @param $jobNo
 * @return string
 */
function GetDivisionWorkUser($jobNo){
	$no = filter_var($jobNo,FILTER_SANITIZE_NUMBER_INT);
	$no = substr($no,- 1,1);
	$divisionWork = getArray("division-work");
	return $divisionWork[$no];
}

/**
 * 获取用户可选择的下拉菜单
 */
function GetdoDistrictSelect(){
	$canDoDistrict = UserLogin::CanDoDistrict();
	global $conf;
	$ddlDistIdSelect = "
	<select name=\"ddlDistId\" id=\"ddlDistId\">
			  	<option value=\"\" selected=\"selected\">All</option>
	";
	$tempDoDist = explode(",",$canDoDistrict);
	foreach($tempDoDist as $k => $v){
		$districtName = $conf['shortDistrictName'][$v];
		if(! empty($districtName)){
			$ddlDistIdSelect .= "        <option value=\"" . $v . "\">" . $districtName . "</option>";
		}
	}
	return $ddlDistIdSelect;
}

/**
 * 將大於24小時的增加
 *
 * @param
 *        	$startTime
 * @param
 *        	$endTime
 */
function ConvertLarge24Hour($startTime,$endTime,$date){
	if(strtotime($startTime) > strtotime($endTime)){
		$time = strtotime($date);
		$time = mktime(0,0,0,date("m",$time),date("d",$time) + 1,date("Y",$time));
		$date = date("Y-m-d",$time);
	}
	return $date . " " . $endTime;
}

/**
 * 獲取指定網頁內容
 *
 * @param $url
 * @param $charset
 */
function get_httpfile($url,$charset = "utf-8"){
	if(function_exists('file_get_contents')){
		$file_contents = @file_get_contents($url);
	}else{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	if($charset == "utf-8"){
		return $file_contents;
	}elseif($charset == "gb2312"){
		$file_contents = iconv("gb2312","UTF-8",$file_contents);
		return $file_contents;
	}
}

/**
 * 转换refNo
 * @param string $refNo
 * @return string
 */
function toShortRefNo($refNo){
	if(strtoupper(substr($refNo,0,2)) == "NE"){
		$refNo = "NE-".intval(substr($refNo,2,3)).substr($refNo,5);
	}
	return $refNo;
}

/**
 * 判断是否手机浏览器
 * @return bool
 */
function isMobileBrowser() {
	$isMobile = false;
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'android') !== false) {
		$isMobile = true;
	}else if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone') !== false) {
		$isMobile = true;
	}else if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
		$isMobile = true;
	}
	return $isMobile;
}

function downloadCsv($data, $strFileName, $delimiter="\t") {//下载电子表格,csv格式
	header("Content-type: text/html; charset=utf-8");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $strFileName . '"');
	header('Cache-Control: max-age=0');
	echo(chr(255).chr(254));
	// 输出标题
	$title = '';
	if (!empty($data['label'])){
		foreach ($data['label'] as $v){
			str_replace(',', ',',$v);
			$title .= trim($v) . $delimiter;
		}
		$title .= "\n";
		echo(mb_convert_encoding($title,"UTF-16LE","UTF-8"));
	}
	// 输出内容
	if (!empty($data['content'])){
		foreach ($data['content'] as $info){
			$content = '';
			foreach ($info as $k =>$v){
				if ($v > 10000000000)
					$v =  "\"".trim($v) ."\t" . "\"";
				else
					$v =  "\"".trim($v) . "\"";
				$content .= $v.$delimiter;
			}
			$content .= "\n";
			echo(mb_convert_encoding($content,"UTF-16LE","UTF-8"));
		}
	}
	exit;
}

/**
 * 获取真实IP地址
 * @return string
 */
function getIP() {
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	}
	elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif (getenv('HTTP_X_FORWARDED')) {
		$ip = getenv('HTTP_X_FORWARDED');
	}
	elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ip = getenv('HTTP_FORWARDED_FOR');

	}
	elseif (getenv('HTTP_FORWARDED')) {
		$ip = getenv('HTTP_FORWARDED');
	}
	else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/**
 * 传入数组，组合sql语句
 * @param array $arr
 * @param string $type
 * @param string $tableName
 * @return string
 */
function makeSql($arr,$type='insert',$tableName=''){
	$filedsArr = array_keys($arr);
	$return = '';
	if($type=='insert'){
		$fileds = $values = '';
		foreach($filedsArr as $v){
			$fileds .= "`$v`,";
		}
		$fileds = rtrim($fileds,',');
		foreach($arr as $v){
			$values .= "'$v',";
		}
		$values = rtrim($values,',');
		$return = "($fileds) VALUE ($values)";
	}
	elseif($type=='update'){
		foreach($filedsArr as $v){
			$return .= "`$v`='{$arr[$v]}',";
		}
		$return = rtrim($return,',');
	}
	elseif($type=='where'){
		foreach($filedsArr as $v){
			if($tableName) $return .= "`$tableName`.`$v`='{$arr[$v]}' AND ";
			else $return .= "`$v`='{$arr[$v]}' AND ";
		}
		$return = rtrim($return,'AND ');
	}
	return $return;
}