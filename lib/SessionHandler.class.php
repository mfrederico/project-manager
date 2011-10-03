<?php

class SessionHandler
{
	var $sessionTable	= 'sessions';
	var $config;
	var $sess_save_path = '';
	var $session_name	= '';
	var $SDB;
	var $redirect		= '';
	var $dbLink;

	function SessionHandler($dbObj,$tableName = "sessions")
	{
		$this->SDB = $dbObj;
		$this->sessionTable = $tableName;
	}

	function _destruct()
	{
		session_write_close();
	}

	function open($save_path, $session_name)
	{
		//...... This stuff isn't necessary, but its more for
		//...... Your "gee-whiz!" collection.
		$this->sess_save_path = $save_path;
		//if (isset($_COOKIE[$session_name])) $this->session_name = $_COOKIE[$session_name];
		$this->session_name = session_id();
		return(true);
	}

	function close()
	{
		//...... Just in case we need to do something on close of our session
		return(true);
	}

	function _createSessionTable()
	{
		$this->SDB->setData("CREATE TABLE {$this->sessionTable} (id char(64) NOT NULL,lastmodified datetime NOT NULL,content text,PRIMARY KEY (id))");
	}

	function read($id)
	{
		$Q="SELECT content FROM {$this->sessionTable} WHERE id='{$id}' LIMIT 1";
		$string = $this->SDB->getOneData($Q);
		//if (!$string) $this->_createSessionTable();
		return (strlen($string['content'])) ? $string['content'] : "";
	}

	function write($id, $sess_data)
	{
		$Q="UPDATE
				{$this->sessionTable}
			SET 
				content=".$this->SDB->quote($sess_data).",
				lastmodified=NOW() 
			WHERE id=".$this->SDB->quote($id);

		$sd = $this->SDB->setData($Q);

		if (!$sd)
		{
			$Q="INSERT INTO 
					{$this->sessionTable}
				SET 	
					content=".$this->SDB->quote($sess_data).",
					lastmodified=NOW(),
					id='{$id}'";
			if (!$this->SDB->setData($Q)); 
		}

		//print "<hr>$Q<hr>";

		return(true);
	}

	function destroy($id)
	{
		$Q="DELETE FROM 
				{$this->sessionTable}
			WHERE id=".$this->SDB->quote($id)." LIMIT 1";
		//return($this->SDB->setData($Q));
	}

	function gc($maxlifetime)
	{
		$Q="DELETE FROM {$this->sessionTable} WHERE lastmodified < $maxlifetime";
		//return($this->SDB->setData($Q));
	}
}

?>
