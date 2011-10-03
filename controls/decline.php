<?php

$type = $_REQUEST['type'];

if (isset($_REQUEST['type']))
{
	$j = R::load($type,$_REQUEST['id']);
	$j->approved = 0;
	$j->archived = 0;
	$id		= R::store($j);
	$this->SMARTY->assign('item',$j->export());

	$this->SMARTY->assign('type',$type);
}


?>
