<?php
	// Just don't even attempt to check if there isn't any login info.
	if (empty($un)) $un = $_REQUEST['login'];
	if (empty($pw)) $pw = $_REQUEST['pass'];

	try 
	{
		$auth = R::findOne('auth',' login=? AND pass=? ',array($un,$pw));
	}
	catch (Exception $e) { }

	if (isset($auth->id) && !empty($auth->id))
	{ 
		$_SESSION['auth_id']    = $auth->id;
		$_SESSION['auth_db']    = $this->config['db']['database'];
		$_SESSION['login']      = $auth->login;
		$_SESSION['pass']       = $auth->pass;
		$this->setRedirect('index.php');
	}
?>
