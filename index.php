<?php
if (!isset($_REQUEST['nogz'])) ob_start('ob_gzhandler');

date_default_timezone_set('America/Los_Angeles');	// Change this to .. Whatever

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");	// Date in the past

	
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors','1');

/**
 * Main front controller
 *
 * @author Matthew Frederico
 * @description Front controller kernel for ultrize system
 * @version 1.5
 **/

//...... Include classes and functions 
include("lib/functions.php");
include("lib/Kernel.class.php");

//..... Instance of Kernel
$K = new Kernel();

$K->startSession(0,0)->			// Start my session handling (persistance,use_db)
			loadClasses()->		// Load up all the classes (smarty etc)
			loadControls()->	// Load controls (pages/actions)
			loadPlugins()->		// Load any plugins
			run();				// compile and run everything!


?>
