<?php

$c = R::load('clients',1);

$fd = fopen('outdata.txt','r');
while (!feof($fd))
{
	$line = fgetcsv($fd,2049,"\t");
	$j	= R::dispense('jobs');
	$j->title=$line[1];
	$j->content=$line[2];
	$j->order=$line[7];
	$j->drivername=$line[4];
	$j->driveremail=$line[3];
	$j->archived=$line[8];
	R::store($j);
	R::associate($c,$j);
}


/*
| id          | int(11) unsigned    | NO   | PRI | NULL    | auto_increment |
| title       | varchar(255)        | YES  |     | NULL    |                |
| content     | varchar(255)        | YES  |     | NULL    |                |
| order       | tinyint(3) unsigned | YES  |     | NULL    |                |
| archived    | tinyint(3) unsigned | YES  |     | NULL    |                |
| drivername  | varchar(255)        | YES  |     | NULL    |                |
| driveremail | varchar(255)        | YES  |     | NULL    |                |
| estimate    | set('1')            | YES  |     | NULL    |                |
| rate        | set('1')            | YES  |     | NULL    |                |
*/


die('imported');

?>
