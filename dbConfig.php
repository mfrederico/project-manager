<?php

// How to get the latest table update information
// select TABLE_SCHEMA,TABLE_NAME,UPDATE_TIME FROM tables WHERE TABLE_NAME='user' AND TABLE_SCHEMA='hawaii';
/* Database Configuration */
$DB_PREFIX='';

if (preg_match('/ultrize.com/',$_SERVER['SERVER_NAME']))
{
    $this->config['db']['host']       = '127.0.0.1';
}
else    
{
	$this->config['db']['host']   = 'ultrize.com';
}

$this->config['db']['database']   = 'ultrizec_ts4';
$this->config['db']['user']       = 'ultrizec';
$this->config['db']['pass']       = '3v4n4j4n3';
$this->config['db']['type']       = 'mysql';
$this->config['prefix']     = $DB_PREFIX;


?>
