<?php
die('already done!');

$c = R::dispense('clients');
$j = R::dispense('jobs');
$t = R::dispense('tasks');
$n = R::dispense('notes');
$f = R::dispense('files');

$c->title	= 'First Client';
$c->order	= 1;

$j->title	= 'First Job';
$j->content	= 'More details';
$j->order	= 1;

$t->title	= 'First Task';
$t->content	= 'More details';
$t->order	= 1;

$n->title	= 'First Note';
$n->content	= 'More details';
$n->order	= 1;

$f->title	= 'First File';
$f->content	= 'Path to file';
$f->order	= 1;

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

print "<h2>Finished.</h2>";
?>
