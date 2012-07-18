<?php
	$data = json_decode(urldecode($_REQUEST['data']),true);
	if (!isset($data)) die("Don't know what to do.");

	$dbFile = basename(dirname($_SERVER['SCRIPT_NAME']));
	if (!file_exists('../timesheet_sqlite_db/'.$dbFile))
	{
		R::setup("sqlite:../timesheet_sqlite_db/{$dbFile}",$this->config['db']['user'],$this->config['db']['pass']);

		R::freeze(false);
		$a = R::dispense('auth');
		$a->title   = $data['user']['name'];
		$a->login   = $data['user']['email'];
		$a->pass    = $data['user']['pass'];
		$a->email    = $data['user']['email'];
		$a->priv    = 'all';
		try { R::store($a); }
		catch (Exception $e)
		{
			die('please hold .. ');
		}

		$u = R::dispense('users');
		$c = R::dispense('clients');
		$j = R::dispense('jobs');
		$t = R::dispense('tasks');
		$n = R::dispense('notes');
		$f = R::dispense('files');

		$u->email	= $data['user']['email'];
		$u->pass	= $data['user']['pass'];
		$u->name	= $data['user']['name'];
		$u->created	= date('Y-m-d H:i:s');
		R::store($u);

		$c->title	= 'First Client';
		$c->order	= 1;

		$j->title	= 'First Job';
		$j->content	= 'More details';
		$j->archived= '0';
		$j->approved= '0';
		$j->content = 'This is the content of your first job.  just a short description of what it is about. Set up tasks by clicking the task icon on the right.';
		$j->approvername = $data['user']['name'];
		$j->approveremail= $data['user']['email'];
		$j->estimate		= '';
		$j->rate          = '';
		$j->updated       = date('Y-m-d H:i:s');
		$j->created		  = date('Y-m-d H:i:s');
		$j->order	= 1;

		$t->title	= 'First Task';
		$t->content	= 'More details';
		$t->archived= '0';
		$t->approved= '0';
		$t->order	= 1;
		$t->content = 'This is a task, it lives inside your jobs.  These can also have approvers attached to them as well';
		$t->approvername = 'Approver';
		$t->approveremail= 'nobody@nowhere.com';
		$t->start		 = '';
		$t->finish		 = '';
		$t->rate          = '';
		$t->updated       = date('Y-m-d H:i:s');
		$t->created		  = date('Y-m-d H:i:s');

		$n->title	= 'First Note';
		$n->content	= 'More details';
		$n->archived= '0';
		$n->approved= '0';
		$n->order	= 1;
		$n->updated       = date('Y-m-d H:i:s');
		$n->created		  = date('Y-m-d H:i:s');

		$f->title	= 'First File';
		$f->content	= 'Path to file';
		$f->archived= '0';
		$f->approved= '0';
		$f->order	= 1;

		/*
		$t->files[]	= $f;
		$t->notes[]	= $n;
		R::store($t);

		$j->tasks[]	= $t;
		$j->files[]	= $f;
		$j->notes[]	= $n;
		R::store($j);

		$c->jobs[]	= $j;
		$c->notes[]	= $n;
		$c->files[]	= $f;
		R::store($c);
		*/

		R::associate($c,$j);
		R::associate($c,$f);
		R::associate($c,$n);

		R::associate($j,$t);
		R::associate($j,$f);
		R::associate($j,$n);

		R::associate($t,$f);
		R::associate($t,$n);


		/*
		// Data initialization
		$c								= new clients();
		$c->title 						= "First Client";
		$c->description					= "First client initialized";
		$c->jobs						= new jobs();

		$c->jobs->title					= 'First Client->Job';
		$c->jobs->description			= 'First Job Description';
		$c->jobs->estimate				= 1.0;
		$c->jobs->rate					= 30.0;
		$c->jobs->files					= new files();
		$c->jobs->notes					= new notes();

		$c->jobs->tasks					= new tasks();
		$c->jobs->tasks->files			= new files();
		$c->jobs->tasks->notes			= new notes();
		$c->jobs->tasks->title			= 'First Job->Task';
		$c->jobs->tasks->description	= 'First Job->Task';
		$c->jobs->tasks->start			= date('Y-m-d h:i:s');
		$c->jobs->tasks->finish			= '0000-00-00 00:00:00';
		$c->jobs->tasks->rate			= $c->jobs->rate;

		$this->DB->store($c);
		*/

		header("Location: /p/{$dbFile}");
	}
	else 
	{
		die("<h2>Projects for \"{$dbFile}\" already setup</h2>");
	}
?>
