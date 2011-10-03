<?php /* Smarty version 2.6.26, created on 2011-09-29 10:32:05
         compiled from editjobs_form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'editjobs_form.html', 7, false),array('modifier', 'stripslashes', 'editjobs_form.html', 9, false),array('modifier', 'htmlentities', 'editjobs_form.html', 9, false),)), $this); ?>
<form method="POST" action="index.php" id="editForm">
<input type="hidden" name="action" value="save">
<input type="hidden" name="type" value="jobs">
<input type="hidden" name="from" value="clients">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
">
<input type="hidden" name="jobs[id]" value="<?php echo $this->_tpl_vars['jobs']['id']; ?>
">
<input type="hidden" name="jobs[archived]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['jobs']['archived'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
">
<h4 style="margin:3px">Title</h4>
<input type="text" name="jobs[title]" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['jobs']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
" style="width:100%"><Br />
<h4 style="margin:3px">Approver</h4>
Name: <input type="text" name="jobs[approvername]" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['jobs']['approvername'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
" style="width:150px">
Email: <input type="text" name="jobs[approveremail]" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['jobs']['approveremail'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
" style="width:150px">
<h4 style="margin:3px">Details</h4>
Time Estimate: <input type="text" name="jobs[estimate]" size="3" value="<?php echo $this->_tpl_vars['jobs']['estimate']; ?>
"> hrs @ Rate: <input type="text" size="5" name="jobs[rate]" value="<?php echo $this->_tpl_vars['jobs']['rate']; ?>
"> <Br />
Description: <br/>
<small style="font-size:8px">
- Create a new TASK from the text following the HYPHEN+space<Br />
! Create a new NOTE from the text following the BANG+space<Br />
</small>
<textarea name="jobs[content]" style="width:100%;height:300px"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['jobs']['content'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</textarea>
</form>