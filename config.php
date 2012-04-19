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
$config['template_path']		= 'media/templates/';

$config['user_name']			= 'Matthew Frederico';
$config['user_email']			= 'mfrederico@gmail.com';
$config['url']					= 'http://www.ultrize.com';

?>
