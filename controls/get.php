<?php

// Allows flexibility of archived to be displayed
$arch		= (!empty($_REQUEST['arch'])) 	  ? 'NOT' : '';
$approved	= (!empty($_REQUEST['approved'])) ? 'NOT' : '';

// Get an object from the DB, and its acompanying template -> json array of each in it's template
//$rendered = false;

// Gets the from object's types
if (!isset($_REQUEST['new']))
{
	$fidx = @$_REQUEST['from'].'_id';
	$tidx = @$_REQUEST['type'].'_id';

	$fid  = @intval($_REQUEST[$fidx]);
	$tid  = @intval($_REQUEST[$tidx]);

	if (!empty($_REQUEST['from']))
	{
		// If we get the entire list of items ('from' only set)
		if (empty($_REQUEST['type'])) $_REQUEST['type'] = $_REQUEST['from'];
		$from		= ($fid) ? R::find($_REQUEST['from'],' id=? ',array(intval($fid))) : R::find($_REQUEST['from']);

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
				$type	= R::related($f,$_REQUEST['type']," archived {$archived}='' AND approved {$approved}='0' ORDER BY `order`");
				foreach($type as $t) 
				{
					$data[$_REQUEST['type']][] = $t->export();
				}
			}
		}

		// If we are updating a specific "top object"
		elseif ($_REQUEST['from'] == $_REQUEST['type'])
		{
			$b = R::find($_REQUEST['type'],' id=? ',array($tid));
			foreach($b as $bb)
				$data[$_REQUEST['type']] = $bb->export();
		}
		// If we are updating a heirarchy
		else
		{
			$b = R::find($_REQUEST['type'],' id=? ',array($tid));
			foreach($b as $bb)
				$data[$_REQUEST['type']][] = $bb->export();
		}
	}
	// Gets just the object type (with id)
	else
	{
		$b = ($tid) ?  R::find($_REQUEST['type'],' id=? ',array($tid)) : R::find($_REQUEST['type']);
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
