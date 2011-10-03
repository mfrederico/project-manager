<?php

// hard code this *for now*
if ($_REQUEST['type'] == 'clients' && !isset($_REQUEST['id'])) $_REQUEST['id'] = 1;

// Get an object from the DB, and its acompanying template -> json array of each in it's template
$rendered = false;


// Gets the from object's types
if (!isset($_REQUEST['new']))
{
	if (!empty($_REQUEST['from']))
	{
		$from		= R::load($_REQUEST['from'],$_REQUEST['id']);
		$data[$_REQUEST['from']] = $from->export();;

		$tidx = $_REQUEST['type'].'_id';
		$tid  = @intval($_REQUEST[$tidx]);

		// If we dont have a type specified
		if (!$tid)
		{	
			$type	= R::related($from,$_REQUEST['type'],' archived=0 ORDER BY `order`');
			foreach($type as $t) $data[$_REQUEST['type']][] = $t->export();
		}
		else
		{
			$b = $this->DB->findOne($_REQUEST['type']," id=? AND archived=0 ",array($tid));
			$data[$_REQUEST['type']][] = $b->export();
		}
	}
	// Gets just the object type (with id)
	else
	{
		$b = $this->DB->findOne($_REQUEST['type']," id=? AND archived=0 ",array($_REQUEST['id']));
		$data[$_REQUEST['type']][] = $b->export();
	}
}

// Return the json only
if (@$_REQUEST['r']  == 'json')
{
	print json_encode($data);
	exit();
}
// Return my form
else if (@$_REQUEST['r'] == 'form' || @$_REQUEST['r'] == 'html')
{
	$d = @$data[$_REQUEST['type']][0];
	$title = "Edit: ".ucfirst($_REQUEST['type']);
	if (isset($_REQUEST['id'])) $this->SMARTY->assign($_REQUEST['type'],$d);
	$form = $this->SMARTY->fetch('edit'.$_REQUEST['type'].'_form.html');
	if ($_REQUEST['r'] == 'form') print  json_encode(array('title'=>$title,'width'=>600,'height'=>600,'editForm'=>rawurlencode($form)));
	else print $form;
}
// Return the json WITH rendered templates
else if (isset($data[$_REQUEST['type']]))
{
	foreach($data[$_REQUEST['type']] as $d)
	{
		$this->SMARTY->assign($_REQUEST['type'],$d);
		$rendered[] = $this->SMARTY->fetch($_REQUEST['type'].".html");
	}
	print json_encode($rendered);
}
else print json_encode(false);

?>
