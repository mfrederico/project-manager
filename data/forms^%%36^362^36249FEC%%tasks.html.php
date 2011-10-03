<?php /* Smarty version 2.6.26, created on 2011-09-29 08:08:16
         compiled from tasks.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'tasks.html', 3, false),array('modifier', 'nl2br', 'tasks.html', 8, false),)), $this); ?>

<li id="tasks_<?php echo $this->_tpl_vars['tasks']['id']; ?>
" class="tasks_widget">
	<div class="label ui-state-default" ><a href="index.php?action=get&type=tasks&id=<?php echo $this->_tpl_vars['tasks']['id']; ?>
&r=form" class="editHandler"><span class="ui-icon ui-icon-note" style="float:left;margin-top:-2px"></span><?php echo ((is_array($_tmp=$this->_tpl_vars['tasks']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</a></div>
	<div class="date ui-state-active">
		<div style="float:left">Start: <?php echo $this->_tpl_vars['tasks']['start']; ?>
</div><div style="float:right">Due: <?php echo $this->_tpl_vars['tasks']['finish']; ?>
</div>
	</div>
	<div id="desc_<?php echo $this->_tpl_vars['tasks']['id']; ?>
" class="ui-state-active desc">
		<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tasks']['content'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>

	</div>
</li>