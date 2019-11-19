<?php
/*
 * Header: 
 * Create: 2015-04-19
 * Auther: James Wu<jamblues@gmail.com>.
 */
class BusDistance
{
	var $budiId;
	var $busId;
	var $stopNo;
	var $stopDescription;
	var $distance;
	var $delFlag = 'no';
	var $order = 'ORDER BY stopNo ASC';
	var $pageLimit;
}
?>