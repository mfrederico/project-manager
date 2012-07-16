<?php
//die('already done!');

$a = R::dispense('auth');

$a->title	= 'Project administrator';
$a->login	= 'login';
$a->pass	= 'pass';
$a->priv	= 'all';
R::store($a);

?>
