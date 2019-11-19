<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}

$bus = new Bus($db);
$bus->routeNo = $_POST['routeNo'];
$bus->typeId = $_POST['typeId'];
$bus->bounds = $_POST['bounds'];
$bus->sofsDate = $_POST['sofsDate'];
$bus->distCode = $_POST['distCode'];
$bus->allSchNo = $_POST['allSchNo'];
$bus->amSchNo = $_POST['amSchNo'];
$bus->pmSchNo = $_POST['pmSchNo'];
$bus->totalJourneyTime = $_POST['totalJourneyTime'];
$bus->totalJourneyDistance = $_POST['totalJourneyDistance'];

$busDay = 'all';
if($_POST['mon'] != "")
	$busDay = $busDay . ',mon';
if($_POST['tue'] != "")
	$busDay = $busDay . ',tue';
if($_POST['wed'] != "")
	$busDay = $busDay . ',wed';
if($_POST['thu'] != "")
	$busDay = $busDay . ',thu';
if($_POST['fri'] != "")
	$busDay = $busDay . ',fri';
if($_POST['sat'] != "")
	$busDay = $busDay . ',sat';
if($_POST['sun'] != "")
	$busDay = $busDay . ',sun';
if($_POST['holiday'] != "")
	$busDay = $busDay . ',holiday';
$bus->busDay = $busDay;
$bus->inputUserId = $_SESSION['userId'];
$bus->inputTime = date($conf['dateTime']['format']);
$busId = $bus->save();
//时间表
$busList = $_POST['busList'];
$list = explode("\r\n",$busList);
$listNo = count($list);
$bt = new BusTime($db);
$bt->busId = $busId;
for($i = 0;$i < $listNo;$i ++){
	if($list[$i] != ""){
		$bt->busTime = $list[$i];
		$bt->Save();
	}
}

// 每个站之间的距离
$stopNoArr = $_POST['stopNo'];
$stopDescriptionArr = $_POST['stopDescription'];
$distanceArr = $_POST['distance'];
$stopNoNum = count($stopNoArr);
$bd = new BusDistance();
$bd->busId = $busId;
$bda = new BusDistanceAccess($db);
for($i=0;$i<$stopNoNum;$i++){
	if(!empty($stopNoArr[$i])) {
		$bd->stopNo = $stopNoArr[$i];
		$bd->stopDescription = str_replace("'", "\\'", $stopDescriptionArr[$i]);
		$bd->distance = $distanceArr[$i];
		$bda->Add($bd);
	}
}

// header("Location:bus_list.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="css/css.css" />
<style type="text/css">
</style>
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="450" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="bus_entry.php">繼續錄入其他,请点击这里.(Continues to enter
						others, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="bus_update.php?busId=<?php echo $busId; ?>">更新,请点击这里.(For
						update information, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					C. <a href="bus_list.php">瀏覽列表,请点击这里.(To browse data List, please
						click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>
