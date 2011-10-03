<?php
// Get an object from the DB, and its acompanying template -> json array of each in it's template
$rendered = false;

$type = $this->DB->resetObj(new $_REQUEST['type']($_REQUEST['id']),'id');
$type->archived = '1';

// Gets the from object's types
if (!empty($_REQUEST['from']))
{
	$from = $this->DB->resetObj(new $_REQUEST['from']($_REQUEST["{$_REQUEST['from']}_id"]),'id');
	$data = $this->DB->orderby($_REQUEST['type'].'_order')->constrainTo($_REQUEST['type'])->getObjsFrom($type,$from);
}
// Gets just the object type (with id)
else
{
	$data = $this->DB->orderby($_REQUEST['type'].'_order')->get($type);
}

// Return the json only
if ($_REQUEST['r']  == 'json')
{
	print json_encode($data);
	exit();
}
// Return my form
else if ($_REQUEST['r'] == 'form')
{
	$d = $data[$_REQUEST['type']][0];
	$title = "Edit: ".ucfirst($_REQUEST['type']);
	if (isset($_REQUEST['id'])) $this->SMARTY->assign($_REQUEST['type'],$d);
	$form = $this->SMARTY->fetch('edit'.$_REQUEST['type'].'_form.html');
	print  json_encode(array('title'=>$title,'width'=>600,'height'=>600,'editForm'=>$form));
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
