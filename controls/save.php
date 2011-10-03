<?php
$replace = 'false';

$type = $_REQUEST['type'];
$from = $_REQUEST['from'];

if (isset($_REQUEST[$type]))
{
	$t = R::dispense($type);
	$t->import($_REQUEST[$type]);
	$id = R::store($t);

	$f = R::load($from,$_REQUEST['id']);

	R::associate($f,$t);

/*
	if (function_exists('onaftersave_'.$_REQUEST['type'])) 
	{
		$func = "onaftersave_{$_REQUEST['type']}";
		$func($this->DB,$j);
	}

*/

    $msg = "{$type} #{$id} Saved.";
	//$returnFunc = "renderObj('index.php?action=get&type={$type}&id={$id}','{$type}','{$replaceId}',$replace);";
	$returnFunc = "refresh('{$from}_{$_REQUEST['id']}');";
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
