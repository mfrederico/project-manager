<?php
$DB_PREFIX='';

// Use the url to get the database name
$this->config['db']['database']   = "../timesheet_sqlite_db".dirname($_SERVER['SCRIPT_NAME']);

$this->config['db']['user']       = 'ultrizec';
$this->config['db']['pass']       = '3v4n4j4n3';
$this->config['db']['type']       = 'sqlite';
$this->config['prefix']     = $DB_PREFIX;


?>
