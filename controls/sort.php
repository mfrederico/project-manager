<?php

$type = $_REQUEST['type'].'_id';
$i = 0;

foreach($_REQUEST[$type] as $idx=>$id)
{
	$j = R::load($_REQUEST['type'],$id);

	if ($j->order != ++$i)
	{
		if ($_REQUEST['type'] == 'jobs')
		{
			if ($j->order > $i) mailUpdate($j,$i);
		}
		$j->order	= $i;
		$ids[$i] = R::store($j);
	}
}
print(json_encode($ids));
exit();

function ordinal($t)
{
	return(sprintf( "%d%s", $t, array_pop( array_slice( array_merge( array( "th","st","nd","rd"), array_fill( 4,6,"th")), $t%10, 1))));
}

function mailUpdate($item,$place)
{
	global $K;
	$p = ordinal($place);
	

	if ($p == 1) $msg = "your project is currently being worked on!";
			else $msg = "your project has been promoted up - This means it will be getting worked on sooner! <br /><br /><b>Exciting isn't it?</b>";

    // DACI - should be "approver" for each task but lets short cut that for now:
    if (!mail("{$item['approvername']} <{$item['approveremail']}>",
            "Taskf.ly: Your project promoted to {$p}!",
			"Project: {$item['title']}<br /><br />\n\n".
            "Since you are the approver on this project, this is just a quick note letting you know that {$msg}",
            "Content-Type: text/html\nFrom: {$K->config['user_name']} via Taskf.ly <{$K->config['user_email']}>"))
    { die('Cannot send approval email!'); }
}


?>
