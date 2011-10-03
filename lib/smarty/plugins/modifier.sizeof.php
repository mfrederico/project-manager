<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty sizeof modifier plugin
 *
 * Type:     modifier<br>
 * Name:     sizeof<br>
 * Purpose:  count the number of elements in an array
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return integer
 */
function smarty_modifier_sizeof($array)
{
    return count($array);
}

/* vim: set expandtab: */

?>
