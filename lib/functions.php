<?php
/********************************************************/
/* List of functions really too odd to be anywhere else */
/********************************************************/
//...... Gives you an array of 'count' files, and 'size' space used
function getSpaceUsed($dir)
{
    $numFiles = 0;
    $spaceUsed = 0;
    if (is_dir($dir))
    {
        if ($dh = opendir($dir))
            while (($file = readdir($dh)) !== false)
                if (filetype($dir.$file) == 'file')
                {
                    $numFiles ++;
                    $spaceUsed += filesize($dir.$file);
                }
        closedir($dh);
    }
    return(array('count'=>$numFiles,'size'=>format_filesize($spaceUsed)));
}


function is_on($str)
{
	return(preg_match('/true|on|1|yes|enabled/i',$str));
}

function loadSqlData($sqlFile)
{
    //...... Loads the sql data file
    if ($fd = fopen($sqlFile,"r"))
    {
        while($Q = fgets($fd,2048))
        {
            if (preg_match("/^--/",trim($Q)))
                continue;
            else
                $qry[$x] .= $Q;
            if (preg_match("/;$/",trim($Q))) $x++;

        }

        //..... Go through each query and send them to mysql
        foreach($qry as $Q)
        {
            $Q=trim($Q);
            if (strlen($Q))
            {
                mysql_query($Q);
            }

            if (mysql_error())
            {
                return(-1);
            }
        }
        return (count($qry) > 0) ? 1 : 0;
    }
    else return(0);
}

function print_pre($str,$str2 = null)
{
	$trace = debug_backtrace();
	$caller = $trace[1];
	if (!isset($caller['class'])) $caller['class'] = 'anon';
	print "<b>{$caller['class']}->{$caller['function']}</b><br />";

	if (is_array($str) && is_array($str2))
	{
		print "<table><thead>";
		print "<th>Var 1</th>";
		print "<th>Var 2</th></thead>";
		print "<tdata><tr>";
		print "<td valign=\"top\"><pre>\n".print_r($str,true)."</pre></td>";
		print "<td valign=\"top\"><pre>\n".print_r($str2,true)."</pre></td>";
		print "</table>";
	}
	else
		print "<pre>".print_r($str,true)."</pre>";
}


function var_name(&$var, $scope=false, $prefix='unique', $suffix='value')
{
    if($scope) $vals = $scope;
    else      $vals = $GLOBALS;
    $old = $var;
    $var = $new = $prefix.rand().$suffix;
    $vname = FALSE;
    foreach($vals as $key => $val) {
      if($val === $new) $vname = $key;
    }
    $var = $old;
    return $vname;
}

function is_admin_ip($ip_addr,$admin_ip_list)
{
	return(in_array($ip_addr,$admin_ip_list));
}


function is_email($email){
return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

function format_filesize($size)
{
    $sizes = Array('B', 'K', 'M', 'G', 'T', 'P', 'E');
    $ext = $sizes[0];
    for ($i=1; (($i < count($sizes)) && ($size >= 1024)); $i++)
    {
        $size = $size / 1024;
        $ext  = $sizes[$i];
    }
    return round($size, 2).$ext;
}

function genPass($size)
{
    $pass = '';
    $alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',1,2,3,4,5,6,7,8,9,0);
    for ($x = 0;$x < $size;$x++)
    {
        $pass .= $alpha[rand(0,count($alpha)-1)];
    }
    return($pass);
}

?>
