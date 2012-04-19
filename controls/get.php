<?php

// Allows flexibility of archived to be displayed
$arch		= (!empty($_REQUEST['arch'])) 	  ? 'NOT' : '';
$approved	= (!empty($_REQUEST['approved'])) ? 'NOT' : '';

// hard code this *for now*
//if ($_REQUEST['type'] == 'clients' && !isset($_REQUEST['clients_id'])) $_REQUEST['clients_id'] = 1;

// Get an object from the DB, and its acompanying template -> json array of each in it's template
$rendered = false;

// Gets the from object's types
if (!isset($_REQUEST['new']))
{
	$fidx = @$_REQUEST['from'].'_id';
	$tidx = @$_REQUEST['type'].'_id';

	$fid  = @intval($_REQUEST[$fidx]);
	$tid  = @intval($_REQUEST[$tidx]);

	if (!empty($_REQUEST['from']))
	{
		$from		= R::load($_REQUEST['from'],intval($fid));
		$data[$_REQUEST['from']] = $from->export();;

		// If we dont have a type specified
		if (!$tid)
		{	
			$type	= R::related($from,$_REQUEST['type']," archived {$archived}='' AND approved {$approved}='0' ORDER BY `order`");
			foreach($type as $t) $data[$_REQUEST['type']][] = $t->export();
		}
    // If we are updating a specific "top object"
    elseif ($_REQUEST['from'] == $_REQUEST['type'])
    {
			$b = R::findOne($_REQUEST['type'],' id=? ',array($tid));
			$data[$_REQUEST['type']] = $b->export();
    }
    // If we are updating a heirarchy
		else
		{
			$b = R::findOne($_REQUEST['type'],' id=? ',array($tid));
			$data[$_REQUEST['type']][] = $b->export();
		}
	}
	// Gets just the object type (with id)
	else
	{
		$b = R::findOne($_REQUEST['type'],' id=? ',array($tid));
		if ($b)
		{
			$data[$_REQUEST['type']][] = $b->export();
		}
	}
}

//print_pre($data);
print json_encode($data);

?>
