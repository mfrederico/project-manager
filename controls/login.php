<?php
	// Just don't even attempt to check if there isn't any login info.
	if (empty($un)) $un = $_REQUEST['login'];
	if (empty($pw)) $pw = $_REQUEST['pass'];

	$auth = R::findOne('auth',' login=? AND pass=? ',array($un,$pw));
	if ($auth->id)
	{ 
		$_SESSION['auth_id']    = $auth->id;
		$_SESSION['login']      = $auth->login;
		$_SESSION['pass']       = $auth->pass;
		$this->setRedirect('index.php');
	}
?>
