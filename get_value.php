<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
switch ($_GET ['item']) {
	case 'bus' :
		$bul = new BusList ( $db );
		$bul->routeNo = $_GET ['routeNo'];
		if ($_GET ['val'] == 'typeId') {
			$post = "''";
			$rs = $bul->GetListSearch ();
			foreach ( $rs as $k => $v ) {
				$post .= "," . $v->bounds . "";
			}
			print $post;
		} else if ($_GET ['val'] == 'schNo') {
			$post = "''";
			$bul->bounds = $_GET ['bounds'];
			$rs = $bul->GetListSearch ();
			foreach ( $rs as $k => $v ) {
				$post .= "," . 'allSchNo:' . $v->allSchNo . "";
				$post .= "," . 'amSchNo:' . $v->amSchNo . "";
				$post .= "," . 'pmSchNo:' . $v->pmSchNo . "";
			}
			print $post;
		}
		break;
	case 'survey' :
		break;
	default :
		break;
}

?>