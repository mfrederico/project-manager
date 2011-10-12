<?php

$type = $_REQUEST['type'];
$type_id = $_REQUEST[$type.'_id'];

if (isset($_REQUEST['type']))
{
	$item = R::load($type,$type_id);
	$item->approved = 1;
	$id		= R::store($item);

	$date = date('Y-m-d H:i:s');
	$content = <<<__EOT__

<h3>{$item['title']}</h3><pre>
Date        : {$date}
Description : {$item['content']}
Approved by : {$item['approvername']} {$item['approveremail']}
</pre>

__EOT__;

    if (!mail("{$this->config['user_name']} <{$this->config['user_email']}>",'MattTask: '.$item['title'].' has been approved!',$content,"Content-Type: text/html\nFrom: {$item['approvername']} <{$item['approveremail']}>")) die('Cannot send approval email!');

}

?>
