<?php /* Smarty version 2.6.26, created on 2011-09-29 10:26:57
         compiled from editnotes_form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'editnotes_form.html', 7, false),array('modifier', 'stripslashes', 'editnotes_form.html', 8, false),array('modifier', 'htmlentities', 'editnotes_form.html', 8, false),)), $this); ?>
<form method="POST" action="index.php" id="editForm">
<input type="hidden" name="action" value="save">
<input type="hidden" name="type" value="notes">
<input type="hidden" name="from" value="jobs">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
">
<input type="hidden" name="notes[id]" value="<?php echo $this->_tpl_vars['notes']['id']; ?>
">
<input type="hidden" name="notes[archived]" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['notes']['archived'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
">
Title: <input type="text" name="notes[title]" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['notes']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
" style="width:100%"><Br />
Description: <Br>
<textarea rows="7" cols="60" name="notes[content]" style="height:400px;width:100%"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['notes']['content'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>
</textarea>
</form>