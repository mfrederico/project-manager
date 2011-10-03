<?php

$type = $_REQUEST['type'];
$i = 0;

foreach($_REQUEST[$type] as $idx=>$id)
{
	$j = R::load($_REQUEST['type'],$id);
	$j->order	= ++$i;
	$ids[$i] = R::store($j);
}
print(json_encode($ids));
exit();
?>
