<?php
// Producion test

// How to get the latest table update information
// select TABLE_SCHEMA,TABLE_NAME,UPDATE_TIME FROM tables WHERE TABLE_NAME='user' AND TABLE_SCHEMA='hawaii';
/* Database Configuration */
$DB_PREFIX='';

$this->config['db']['database']   = 'ultrizec_ts4';
$this->config['db']['user']       = 'ultrizec';
$this->config['db']['pass']       = '3v4n4j4n3';
$this->config['db']['type']       = 'mysql';
$this->config['db']['port']       = '3306';

if (preg_match('/ultrize.com/',$_SERVER['SERVER_NAME']))
{
    $this->config['db']['host']       = '127.0.0.1';
}
elseif(preg_match('/dotcloud.com/',$_SERVER['SERVER_NAME']))
{
	$envjson = json_decode(file_get_contents("/home/dotcloud/environment.json"),true);
	list($db,$user,$pass) = explode(':',$envjson);
	$user = str_replace('//','',$user);
	list($pass,$user) = explode('@',$pass);

	$this->config['db']['user']       = $user;
	$this->config['db']['pass']       = $pass;

    $this->config['db']['host']       = $envjson['DOTCLOUD_DB_MYSQL_HOST'];
    $this->config['db']['port']       = $envjson['DOTCLOUD_DB_MYSQL_PORT'];
}
else    
{
	$this->config['db']['host']   = 'ultrize.com';
}

$this->config['prefix']     = $DB_PREFIX;


?>
