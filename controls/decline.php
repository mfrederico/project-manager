<?php

$type = $_REQUEST['type'];
$type_id = $_REQUEST[$type.'_id'];

if (isset($_REQUEST['type']))
{
	$item = R::load($type,$type_id);
	$item->approved = 0;
	$item->archived = 0;
	$id	= R::store($item);
}

?>
