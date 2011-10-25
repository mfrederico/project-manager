<?php
		
/**
 * Kernel Class
 *
 * @package Kernel
 * @author Matthew Frederico
 * @description Kernel state for ultrize
 * @version 1.5
 **/

class Kernel
{
	//..... Store Debug info
	var $DBG		=1;

	//..... Query string data for rewriteability
	var $_QSDATA    = array();

	//..... Media and lib and controls	
	var $controls	='';
	var $media		='';
	var $lib	='';
	var $classPath  = '';
	var $config		= array();
	var $classFiles = array();

	//..... Page and action authentication requirements
	var $controlAuth= array();

	//..... Holders for objects
	var $c			= array();
	var $M			= ''; // Menu System

	//..... Running Code Controls
	var $code		= '';
	var $method		= 'init';
	var $controlType= '';
	var $codeFiles	= array();
	var $pluginFiles= array();
	var $origCid	= '';
	var $origDir	= '';
	var $codeFileIdx= 0;


	//..... Output Data
	var $outputData	= array();
	var $pageTitle	= '';
	var $redirect	= '';
	var $layout		= '';


	//..... Error array
	var $KERNEL_ERROR = array();
	var $sortIdx = '';

	function Kernel($configFile='config.php',$dbConfig='dbConfig.php',$controls='controls',$media='media',$lib='lib')
	{
		$this->controls	= $controls;	
		$this->lib = $lib;	
		$this->media	= $media;	
		$this->origDir	= getcwd();
		$this->init($configFile,$dbConfig);

		$this->setLayout('default');
		return($this);
	}

	function init($configFile = 'config.php',$dbConfig = 'dbConfig.php')
	{
		// Connect to the database
		if (file_exists($dbConfig))
		{
			include($dbConfig);
			//include_once($this->lib.'/norm.php');
			//$this->DB = new Norm("{$this->config['db']['type']}:host={$this->config['db']['host']};dbname={$this->config['db']['database']}",$this->config['db']['user'],$this->config['db']['pass']);
			include_once($this->lib.'/rb.php');
			$this->DB = R::setup("{$this->config['db']['type']}:host={$this->config['db']['host']};dbname={$this->config['db']['database']}",$this->config['db']['user'],$this->config['db']['pass']);
		}

		// Load configuration Data
		if (file_exists($configFile))
		{
			include($configFile);
			$this->config	= $config;
		}
		else
		{
			$this->KERNEL_ERROR['init'][] = "init: Cannot find $configFile";
			return(null);
		}
	}

	//...... Sets the path for the class
	function setClassPath($classPath)
	{
		$this->classPath = $classPath;
	}

	//...... Adds classes to load dynamically.
	function addClass($classFile)
	{
		$this->classFiles[] = $classFile;	
	}

	//...... As long as the class name is the same as the instance name, 
	//..... (Which in good OOP it should be)
	//...... Also, if the class as the "setDB" method, populates it with the current
	//...... DB connection string.
	function loadClasses()
	{
		if (!strlen($this->classPath)) $this->classPath = $this->lib;
		foreach($this->classFiles as $classFile)
		{
			include_once("{$this->classPath}/$classFile");
			list($className) = explode(".",basename($classFile),2);
			$classNameUC = strtoupper($className);
			if (class_exists($className))
			{
				try
				{
					//$this->c[$classNameUC] = new $className();
					$this->$classNameUC = new $className();
					if (method_exists($this->$classNameUC,'init')) $this->$classNameUC->init($this->DB);
				}
				catch(Exception $e)
				{
					print("Class {$className} not callable.");
				}
		
			}	
		}
		$this->setupClasses();
		return($this);
	}

	function setupClasses()
	{
		if (isset($_REQUEST['dbg'])) $this->SMARTY->debugging     = true;
		$this->origCid                  = $this->SMARTY->compile_id;

		return($this);
	}

	//...... Sets the authentication level for a specific control file
	function setAuth($control,$file,$level = 1)
	{
		$this->controlAuth[$control][$file] = $level;
	}
	
	//...... Make sure auth level can "See" the pages and actions
	function authControl($controlName,$controlType)
	{
		$controlName = addslashes($controlName);
		$controlType = addslashes($controlType);
		return(true);
	}

	// Parse the parameters coming in
	function parseParams()
	{
		if (isset($argv))
		{
			if      ($argv[1] == 'a')   $_REQUEST['action'] = $argv[2];
			elseif  ($argv[1] == 'p')   $_REQUEST['page']   = $argv[2];
		}

		//...... This does our magical rewrite functions
		//...... Sets up _QSDATA
		if (isset($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'],'index.php/'))
		{
			list($baseURI,$rewrite) = explode("index.php/",$_SERVER['REQUEST_URI']);

			if (!isset($this->config['site']['base_url']))  $this->config['site']['base_url'] = $baseURI;
			if (!isset($this->config['site']['media_url'])) $this->config['site']['media_url'] = $baseURI."media/";

			if ($rewrite)
			{
				$stateInfo = explode("/",$rewrite);
				$_REQUEST["{$stateInfo[0]}"] = $stateInfo[1];

				@list($baseURI,$_REQUEST['id']) = (explode(".",$rewrite,3));
				$_REQUEST['id'] = intVal($_REQUEST['id']);

				$this->_QSDATA = explode("/",$rewrite);
			}
		}
		else
		{
			//...... Sets up the minimally default base paths
			@list($baseURI,$rewrite) = explode("index.php",$_SERVER['REQUEST_URI']);
			if (!isset($this->config['site']['base_url']))  $this->config['site']['base_url'] = $baseURI;
			if (!isset($this->config['site']['media_url'])) $this->config['site']['media_url'] = $baseURI."media/";
			if ($rewrite) $this->_QSDATA   = explode("/",$rewrite);
		}
	}


	/* @description sets up the page/action request controls */
	function loadControls()
	{
		$this->parseParams();

		if		(isset($_REQUEST['page']))		$control = 'page';
		elseif	(isset($_REQUEST['pg']))		$control = 'page';
		elseif	(isset($_REQUEST['pt']))		$control = 'part';
		elseif	(isset($_REQUEST['part']))		$control = 'part';
		elseif	(isset($_REQUEST['action']))	$control = 'action';
		elseif	(isset($_REQUEST['act']))		$control = 'action';
		else 
		{
			$control = 'page';
			$_REQUEST['page'] = $this->DEFAULT_PAGE;
		}
		//...... Try to authenticate this page form the control_perms table
		if (!$this->authControl($_REQUEST[$control],$control))
		{
			unset($_REQUEST);
			$control='page';
			$_REQUEST['page'] = $this->DEFAULT_PAGE;
		}
		$this->controlType	= $control;
		$this->code			= basename($_REQUEST[$control]);

		// Parse my control class and method
		if (strchr($this->code,'.')) list($this->code,$this->method) = explode('.',$this->code);
		else $this->method = 'init';

		// the difference between a "part" and a "page" is a part has no layout
		if ($this->controlType == 'part') $this->setLayout(null);

		if (!isset($this->controlAuth[$control][$this->code]))
			$this->controlAuth[$control][$this->code] = 0;

		$this->setCodeFile('main',$this->code,'',$this->controlType,'main',$this->method);
		return($this);
	}

	function loadPlugins()
	{
		$x = 0;
		if (isset($this->config['plugins']))
		{
			foreach($this->config['plugins'] as $plugin=>$is_on)
			{
				if (Kernel::is_on($is_on))
				{
					$dir = "{$this->config['global']['plugin_path']}/{$plugin}";
					$plugin_file_path = "{$dir}/{$this->controls}/{$this->controlType}";

					if (!isset($this->controlAuth[$this->controlType][$this->code]))
						$this->controlAuth[$this->controlType][$this->code] = 0;

					//...... Actually load the plugin
					if (file_exists("{$plugin_file_path}/{$this->code}.php"))
					{
						include("{$dir}/config.php");
					}
					else
					{
						if ($this->DBG > 1) $this->KERNEL_ERROR['plugins'][] = "loadPlugins: Plugin enabled, but cannot find {$this->code} at ($plugin_path)";
					}
				}
			}
		}
		return($this);
	}

    function setCodeFile($type,$code,$dir,$controlType,$order='main',$method='init') // or pre
    {
        $this->codeFileIdx++;

        //..... File that will be run
        $this->codeFiles[$type][$this->codeFileIdx]['codeFile']     = $this->code;

        //..... Relative directory file lives in
        $this->codeFiles[$type][$this->codeFileIdx]['dir']          = $dir;

        //..... Control type (page / action)
        $this->codeFiles[$type][$this->codeFileIdx]['controlType']  = $this->controlType;

        //..... When to load this plugin
        $this->codeFiles[$type][$this->codeFileIdx]['order']		= $order;

        //..... What method to trigger when we load this plugin
        $this->codeFiles[$type][$this->codeFileIdx]['method']		= $method;

    }


	//...... Runs my code in the "order" it was received (some day)
	function run()
	{
		$this->runCode($this->codeFiles);
		$this->display();
		return($this);
	}

	//...... Runs each code file in the codeFiles array
	function runCode($files)
	{
		$has_main	= 0;
		$lastDir	= '';
		$tplData	= '';
		$classNameUC= '';

		if (count($files))
		{
			foreach($files as $plugType=>$codeBases) 
			{
				//..... First load all code / variables
				foreach($codeBases as $idx=>$codeBase)
				{
					//...... Reset position type
					$pos	= "content";

					//..... Chdir to plugin codebase
					if (strlen($codeBase['dir'])) chdir($codeBase['dir']);

					//print "$plugType: {$codeBase['codeFile']}";
					//...... POS will get re-set here if applicable to this plugin
					if (file_exists("{$this->controls}/{$codeBase['codeFile']}.php"))
					{
						require_once("{$this->controls}/{$codeBase['codeFile']}.php");
						$className = ucfirst($this->code);
						if (class_exists($className))
						{
							try
							{
								$classNameUC = new $className();
								if (method_exists($classNameUC,'init')) $classNameUC->init($this);
								$classNameUC->{$this->method}($_REQUEST);
							}
							catch(Exception $e)
							{
								print("Class {$className} not callable.");
							}
					
						}	

						$codePos[$codeBase['dir'].$codeBase['codeFile']] = $pos;
						if ($plugType == 'main') $has_main++;
					}
					else $codePos[$codeBase['dir'].$codeBase['codeFile']] = 'content';

					//..... Go back to original directory
					if (strlen($codeBase['dir'])) chdir($this->origDir);
				}
			}

			//..... Next, Parse and loads the smarty template output
			foreach($files as $plugType=>$codeBases) 
			{
				foreach($codeBases as $codeBase)
				{
					$pos = $codePos[$codeBase['dir'].$codeBase['codeFile']];
					if (!strlen($pos)) $pos = 'content';

					//..... Chdir to plugin codebase
					if (strlen($codeBase['dir'])) chdir($codeBase['dir']);

					if ($codeBase['controlType'] == 'page' || $codeBase['controlType'] == 'part')
					{
						// If we are rendering a partial .. 
		 				if ($codeBase['controlType'] == 'part') $codeBase['codeFile'] = $codeBase['codeFile'].'.'.$codeBase['method'];
						if (file_exists($this->config['template_path'].$codeBase['codeFile'].'.html'))
						{
							$tplData = $this->config['template_path']."{$codeBase['codeFile']}.html";
						}
						else
						{
							$tplData = $this->config['template_path']."blank.html";
						}
						$this->outputData[$pos][]	= $tplData;
					}

					//..... Go back to original directory
					if (strlen($codeBase['dir'])) chdir($this->origDir);
				}
				//...... Are we running code for main functionality, to allow plugin handling
			}
		}
	}

	function setPageTitle($title)
	{
		$this->pageTitle = $title;
	}
	
	function setRedirect($redirect)
	{
		$this->redirect = $redirect;
	}

	/* Set the template layout to use */
	function setLayout($layout)
	{
		$layout = basename($layout);
		if ($layout) $this->layout = "layouts/{$layout}.html";
		else $this->layout = '';
	}

	function getLayout()
	{
		if (isset($this->layout) && strlen($this->layout)) return($this->layout);
		else return('layouts/passthrough.html');
	}

	function display()
	{
		//..... USUALLY comes from a page -- display
		if ($this->controlType == 'page' OR $this->controlType == 'part')
		{
			if (isset($_GET['layout'])) $this->setLayout($_GET['layout']);
			if (isset($_GET['l'])) $this->setLayout($_GET['l']);
			include($this->config['template_path'].$this->getLayout());
			ob_implicit_flush();
			ob_flush();
			foreach($this->outputData as $k=>$v)
			{
				foreach($v as $page)
				{
					//print "<script>\$(function(){\$('#{$k}').append(\$.ajax({ url: '{$page}', async:false}).responseText);});</script>";
					include($page);
				}
			}
		}
		//...... USUALLY comes from an action or no display
		if (strlen($this->redirect))	
		{
			session_write_close();
			header("Location: $this->redirect");
		}
	}

	function startSession($session_persist = 1,$use_db = 1)
	{
		if (isset($_COOKIE['unique_cookie'])) session_name($_COOKIE['unique_cookie']);
		session_start();
		return($this);
	}

	/**
	* is_on
	*
	* @description Boolean expression to check if something is on
	* @returns 1 / 0
	**/

	function is_on($str)
	{
		return(preg_match('/true|on|1|yes|enabled/i',$str));
	}

	function timeFormat($seconds)
	{
		if ($seconds == 0) return('00:00:00');
		$days = intval($seconds / 86400);
		$rem = fmod($seconds,86400);
		$hours = sprintf('%02d',intval($rem / 3600));
		$rem = fmod($rem,3600);
		$minutes = sprintf('%02d',intval($rem / 60));
		$rem = fmod($rem,60);
		$seconds = sprintf('%02d',intval($rem));
		//return (array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds));
		if ($days) $days = "{$days}D "; else $days = '';
		return ("{$days}{$hours}:{$minutes}:{$seconds}");
	}


}

class Exhandler extends Exception
{
	protected $userMessage;

	public function setUserMessage($msg)
	{
		$this->userMessage = $msg;
	}
	public function getUserMessage()
	{
		return($this->userMessage);
	}
}

?>
