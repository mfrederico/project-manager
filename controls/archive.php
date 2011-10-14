<?php
$replace = 'false';

$type		= $_REQUEST['type'];
$type_id	= intval($_REQUEST[$type.'_id']);

$notes = '';
$item  = '';
$tasks = '';

if (isset($_REQUEST['type']))
{
	$j = R::load($type,$type_id);
	$j->archived = date('Y-m-d H:i:s');;
    R::store($j);

	$item = $j->export();

	if (strlen($item['approvername']) && strlen($item['approveremail']))
	{
		$n = R::related($j,'notes');
		foreach($n as $k) $notes[] = $k->export();

		if ($type == 'jobs') 
		{
			$t = R::related($j,'tasks');
			foreach($t as $k) $tasks[] = $k->export();
		}
		approval($this,$type,$item,$notes,$tasks);
	}

	$replaceId = "{$type}_{$type_id}";

    $msg = "{$type} #{$type_id} archived.";
	$returnFunc = "removeWidget('#{$_REQUEST['type']}_id_{$type_id}');";//renderObj('index.php?action=get&type={$type}&id={$type_id}','{$type}','{$replaceId}',$replace);";
}

print json_encode(array('msg'=>$msg,'func'=>$returnFunc));

function approval($d,$type,$item,$notes = array(),$tasks = array())
{
	$uri = $_SERVER['REQUEST_URI'];

	$uri = str_replace('action','page',$uri);
	$uri = str_replace('archive','approve',$uri);
	$approve_url = $d->config['url'].$uri;

	$uri = str_replace('approve','decline',$uri);
	$decline_url = $d->config['url'].$uri;

	$type = rtrim(ucfirst($type),'s');
	ob_start();
	include_once($d->config['template_path'].'approval.html');
	$content = ob_get_contents();
	ob_end_clean();

	if (isset($_REQUEST['show'])) die($content);

	// DACI - should be "approver" for each task but lets short cut that for now:
	if (!mail("{$item['approvername']} <{$item['approveremail']}>",
			'MattTask: '.$item['title'].' please approve!',
			$content,
			"Content-Type: text/html\nFrom: {$d->config['user_name']} via MattTask <{$d->config['user_email']}>")) 
	{ die('Cannot send approval email!'); }
}


?>
