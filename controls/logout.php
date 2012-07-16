<?php
	unset($_SESSION['auth_id']);
	unset($_SESSION['login']);
	unset($_SESSION['pass']);

	session_write_close();
	header("Location: index.php");
?>
