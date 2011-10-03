<?php
//Project Definitions and Default Page
$this->DEFAULT_PAGE    = 'index';
$this->PROJECT         = 'forms';

//Get the current directory
$this->cwd = getcwd();

/* Path Information */
//session_save_path:Make sure this is read and writeable by the webserver user
$config['session_save_path']	= $this->cwd.'/data/';

//template_cache_dir:Make sure this is read and writeable by the webserver user
$config['template_cache_dir']	= $this->cwd.'/data/';

//...... Load any classes here
$this->addClass('smarty/Smarty.class.php');

include_once('lib/datastruct.php');

?>
