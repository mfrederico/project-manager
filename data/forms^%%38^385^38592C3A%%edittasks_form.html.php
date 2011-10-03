<?php /* Smarty version 2.6.26, created on 2011-09-29 08:05:56
         compiled from edittasks_form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'edittasks_form.html', 7, false),array('modifier', 'stripslashes', 'edittasks_form.html', 9, false),array('modifier', 'htmlentities', 'edittasks_form.html', 9, false),)), $this); ?>
<form method="POST" action="index.php" id="editForm">
<input type="hidden" name="action" value="save">
<input type="hidden" name="type" value="tasks">
<input type="hidden" name="from" value="jobs">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
">
<input type="hidden" name="tasks[id]" value="<?php echo $this->_tpl_vars['tasks']['id']; ?>
">
<input type="hidden" name="tasks[archived]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['tasks']['archived'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
">
<h4 style="padding:0px;margin:0px;">Task Info:</h4>
Title: <input type="text" name="tasks[title]" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tasks']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
"> Rate: <input type="text" name="tasks[rate]" value="<?php echo $this->_tpl_vars['tasks']['rate']; ?>
" size="6"> <Br />
Date Start: <input id="start" class="date" type="text" name="tasks[start]" value="<?php echo $this->_tpl_vars['tasks']['start']; ?>
"> Date Finish Est: <input id="finish" class="date" type="text" name="tasks[finish]" value="<?php echo $this->_tpl_vars['tasks']['finish']; ?>
"> <Br />
<h4 style="padding:0px;margin:0px">Approver</h4>
Name: <input type="text" name="tasks[approvername]" value="<?php echo $this->_tpl_vars['tasks']['approvername']; ?>
"> Email: <input type="text" name="tasks[approveremail]" value="<?php echo $this->_tpl_vars['tasks']['approveremail']; ?>
"> <Br />
<h4 style="padding:0px;margin:0px;">Task Description:</h4>
<textarea name="tasks[content]" rows="7" cols="60" style="width:100%;height:300px"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tasks']['content'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</textarea><Br />
</form>
<script>
	$('#finish').datepicker({ showOn:'focus'});
	$('#start').datepicker({ showOn:'focus'});
</script>