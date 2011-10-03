<?php /* Smarty version 2.6.26, created on 2011-09-29 10:27:07
         compiled from notes.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'notes.html', 3, false),array('modifier', 'truncate', 'notes.html', 3, false),array('modifier', 'date_format', 'notes.html', 4, false),)), $this); ?>

<li id="notes_<?php echo $this->_tpl_vars['notes']['id']; ?>
" class="notes_widget">
	<div class="label ui-state-default" style="height:15px"><a href="index.php?action=get&type=notes&id=<?php echo $this->_tpl_vars['notes']['id']; ?>
&r=form" class="editHandler"><span class="ui-icon ui-icon-comment" style="float:left;margin-top:-2px"></span><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['notes']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 60, " ...") : smarty_modifier_truncate($_tmp, 60, " ...")); ?>
</a>
		<div style="float:right"><?php echo ((is_array($_tmp=$this->_tpl_vars['notes']['updated'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
	</div>
</li>
