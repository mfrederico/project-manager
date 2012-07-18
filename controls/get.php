<?php

// Allows flexibility of archived to be displayed
$arch		= (!empty($_REQUEST['arch'])) 	  ? 'NOT' : '';
$approved	= (!empty($_REQUEST['approved'])) ? 'NOT' : '';

if (isset($_REQUEST['dbg'])) R::debug(TRUE);

// Gets the from object's types
if (!isset($_REQUEST['new']))
{
	$fidx = @$_REQUEST['from'].'_id';
	$tidx = @$_REQUEST['type'].'_id';

	$fid  = @intval($_REQUEST[$fidx]);
	$tid  = @intval($_REQUEST[$tidx]);

	$archapproved = "archived {$archived}=0 AND approved {$approved}=0 ORDER BY `order`";

	if (!empty($_REQUEST['from']))
	{
		// If we get the entire list of items ('from' only set)
		if (empty($_REQUEST['type'])) $_REQUEST['type'] = $_REQUEST['from'];
		$from		= ($fid) ? R::find($_REQUEST['from'],' id=? AND '.$archapproved,array(intval($fid))) : R::find($_REQUEST['from'], $archapproved);

	 	// All the found beans, will you please stand up
		foreach($from as $f)
		{
			$data[$_REQUEST['from']][] = $f->export();
		}

		// If we dont have a type specified
		if (!$tid && $_REQUEST['from'] != $_REQUEST['type'])
		{	
			foreach($from as $f)
			{
				$type	= R::related($f, $_REQUEST['type'], $archapproved);
				foreach ($type as $t) 
				{
					$data[$_REQUEST['type']][] = $t->export();
				}
			}
		}
		// Grab entire heirarchy
		else
		{
			$b = R::find($_REQUEST['type'],' id=? AND ' . $archapproved, array($tid));
			foreach($b as $bb)
				$data[$_REQUEST['type']][] = $bb->export();
		}
	}
	// Gets just the object type (with id)
	else
	{
		$b = ($tid) ?  R::find($_REQUEST['type'],' id=? '. $archapproved, array($tid)) : R::find($_REQUEST['type'], $archapproved);
		if ($b)
		{
			foreach($b as $bb)
				$data[$_REQUEST['type']][] = $bb->export();
		}
	}
}

if($_REQUEST['r'] == 'array') print "<pre>".print_r($data,true)."</pre>";
else
	print json_encode($data);

?>
