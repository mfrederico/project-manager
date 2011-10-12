<?php

// Allows flexibility of archived to be displayed
$arch		= (!empty($_REQUEST['arch'])) ? intval($_REQUEST['arch']) : 0;
$approved	= (!empty($_REQUEST['approved'])) ? intval($_REQUEST['approved']) : 0;

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
			$type	= R::related($from,$_REQUEST['type'],' archived=? AND approved=? ORDER BY `order`',array($arch,$approved));
			foreach($type as $t) $data[$_REQUEST['type']][] = $t->export();
		}
		else
		{
			$b = $this->DB->findOne($_REQUEST['type'],' id=? ',array($tid));
			$data[$_REQUEST['type']][] = $b->export();
		}
	}
	// Gets just the object type (with id)
	else
	{
		$b = $this->DB->findOne($_REQUEST['type'],' id=? ',array($tid));
		$data[$_REQUEST['type']][] = $b->export();
	}
}

print json_encode($data);

?>
