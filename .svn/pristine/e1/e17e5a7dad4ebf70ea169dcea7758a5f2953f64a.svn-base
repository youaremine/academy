<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
switch ($_GET ['item']) {
	case 'bus' :
		$item = 'bus';
		$bus = new Bus ( $db );
		$bus->routeNo = $_GET ['routeNo'];
		if ($bus->IsExist ()) {
			print "successful";
		} else {
			print "failed";
		}
		break;
	case 'survey' :
		$item = 'survey';
		break;
	default :
		$item = 'bus';
		break;
}

?>