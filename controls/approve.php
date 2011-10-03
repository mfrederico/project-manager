<?php

$type = $_REQUEST['type'];

if (isset($_REQUEST['type']))
{
	$j = R::load($type,$_REQUEST['id']);
	$j->approved = 1;
	$id		= R::store($j);
	$this->SMARTY->assign('item',$j->export());

	$date = date('Y-m-d H:i:s');
	$content = <<<__EOT__

<h3>{$type}</h3><pre>
Title       : {$j['title']}
Description : {$j['content']}
Date        : {$date}
Approved by : {$j['approvername']} {$j['approveremail']}
</pre>

__EOT__;

    if (!mail("Matthew Frederico <mfrederi@adobe.com>",'MattTask: '.$j['title'].' has been approved!',$content,"Content-Type: text/html\nFrom: {$j['approvername']} <{$j['approveremail']}>")) die('Cannot send approval email!');

}

?>
