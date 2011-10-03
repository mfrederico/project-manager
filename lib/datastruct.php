<?php

R::debug(isset($_REQUEST['dbg']));

/*


class clients
{
	public function __construct($id='')
	{
		if (!empty($id)) $this->id = intval($id);
	}
	var $title = '';
	var $description = '';
	var $funds = '';
	var $archived = 0.0;
	var $order		= 0.0;
}

class jobs
{
	public function __construct($id='')
	{
		if (!empty($id)) $this->id = intval($id);
	}

	public function onArchive($d)
	{
		$this->id = intval($_REQUEST['id']);
		$item       = $d->DB->constrainTo('jobs,notes')->get($this)->results;

		if (strlen($item['jobs'][0]['driveremail']))
		{
			$uri = $_SERVER['REQUEST_URI'];
			$uri = str_replace('archive','approval',$uri);
			$d->SMARTY->assign('approve_url','http://'.$_SERVER['SERVER_NAME'].$uri.'&approval=true');
			$d->SMARTY->assign('decline_url','http://'.$_SERVER['SERVER_NAME'].$uri.'&approval=false');
			$d->SMARTY->assign('item',$item['jobs'][0]);
			$d->SMARTY->assign('notes',$item['jobs'][0]['notes']);
			$content = $d->SMARTY->fetch('approval.html');

			// DACI - should be "approver" for each task but lets short cut that for now:
			if (!mail("{$item['jobs'][0]['drivername']} <{$item['jobs'][0]['driveremail']}>",'MattTask: '.$item['jobs'][0]['title'].' please approve!',$content,"Content-Type: text/html\nFrom: MattTask <mfrederi@adobe.com>")) die('Cannot send approval email!');
		}	
	}

	var $title			= '';
	var $description	= '';
	var $estimate		= 0.0;
	var $rate			= 0.0;
	var $approved		= 0;
	var $drivername		= '';
	var $driveremail	= '';
	var $archived		= '0';
	var $order			= 0.0;
}

class tasks
{
	public function __construct($id='')
	{
		if (!empty($id)) $this->id = intval($id);
	}
	var $title			= '';
	var $description	= '';
	var $start			= '';
	var $finish			= '';
	var $rate			= 0.0;
	var $order		= 0.0;
}

class files
{
	public function __construct($id='')
	{
		if (!empty($id)) $this->id = intval($id);
	}
	var $title			= '';
	var $description	= '';
	var $filesize		= 0.0;
	var $archived		= 0.0;
	var $order			= 0.0;
}

class notes
{
	public function __construct($id='')
	{
		if (!empty($id)) $this->id = intval($id);
	}
	var $title			= '';
	var $note			= '';
	var $archived		= 0.0;
	var $order		= 0.0;
}
*/
?>
