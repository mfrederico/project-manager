<?php /* Smarty version 2.6.26, created on 2011-09-29 08:08:11
         compiled from layouts/default.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Current Projects</title>

<link href="http://cdn.wijmo.com/themes/aristo/jquery-wijmo.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

   <link rel="stylesheet" href="media/css/styles.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="media/css/print.css" type="text/css" media="print" />
	<script src="media/js/editHandler.js" type="text/javascript"></script>
	<script src="media/js/rendering.js" type="text/javascript"></script>
</head>
<style>
	.orange { color: orange}
	.logo	{ color:black;text-align:left;padding-left:20px;height:40px;font-size:25px;float:left;}
	#menu 	{ width:100%;clear:both;height:30px;}
	.menu-list	{ padding-left:30px;float:left;line-height:30px;};
</style>

<body>
	<div>
		<div id="menu" class="ui-state-default">
			<div class="logo"><span class="orange">Matt</span>Task</div>
			<div class="menu-list" >Menu Goes Here</div>
		</div>
		<div class="content">
			<?php $_from = $this->_tpl_vars['output']['append']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['header'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['header']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['header']['iteration']++;
?><?php echo $this->_tpl_vars['data']; ?>
<?php endforeach; endif; unset($_from); ?>
		</div>
	</div>
</body>
</html>