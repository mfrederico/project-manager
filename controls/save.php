<?php
$replace = 'false';

$type = $_REQUEST['type'];
$from = $_REQUEST['from'];

$type_id = $_REQUEST[$type]['id'];
$from_id = $_REQUEST[$from.'_id'];

if (isset($_REQUEST[$type]))
{
	$t = R::dispense($type);
	$t->import($_REQUEST[$type]);
	$id = R::store($t);

	$f = R::load($from,$_REQUEST[$from.'_id']);

	R::associate($f,$t);

/*
	if (function_exists('onaftersave_'.$_REQUEST['type'])) 
	{
		$func = "onaftersave_{$_REQUEST['type']}";
		$func($this->DB,$j);
	}

*/

	$replace = ($type_id > 0) ? $type_id : '0';

    $msg = "{$type} #{$id} Saved.";
	$returnFunc = "renderObj('index.php?action=get&from={$from}&{$from}_id={$from_id}&type={$type}&{$type}_id={$id}','{$type}','#{$from}_id_{$from_id} .{$type}',$replace);";
	//$returnFunc = "refresh('#{$type}_id_{$_REQUEST[$type]['id']}');";
}

if ($_REQUEST['r'] == 'json') print json_encode(array('msg'=>$msg,'func'=>$returnFunc));

//***********************************/
// Callback functions go here
//***********************************/

// This auto-splits out new tasks and new notes on init of a job
function onaftersave_jobs($DB,$data)
{
	$t = 0;
	$n = 0;
	$lines = explode("\n",$data->description);
	foreach($lines as $lidx=>$line)
	{
		if (substr($line,0,2) == '- ') 
		{
			$data->tasks[$t] = new tasks();
			$data->tasks[$t]->title = substr($line,2);
			$data->tasks[$t]->order = $t+1;
			$t++;
			unset($lines[$lidx]);
		}
		if (substr($line,0,2) == '! ') 
		{
			$data->notes[$n] = new notes();
			$data->notes[$n]->title = substr($line,2);
			$data->notes[$n]->order = $n+1;
			$n++;
			unset($lines[$lidx]);
		}
	}
	$data->description = join("\n",$lines);
	$DB->store($data);
}


?>
