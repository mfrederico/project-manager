<?php /* Smarty version 2.6.26, created on 2011-09-29 08:08:06
         compiled from clients.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'clients.html', 5, false),)), $this); ?>
<div class="clients ui-corners-top" id="clients_<?php echo $this->_tpl_vars['clients']['id']; ?>
">
	<div class="ui-state-default">
		<div class="label">
			<a class="ui-button ui-icon ui-icon-triangle-1-e show default" name="jobs" target="clients_<?php echo $this->_tpl_vars['clients']['id']; ?>
 .jobs" href="index.php?action=get&type=jobs&from=clients&id=<?php echo $this->_tpl_vars['clients']['id']; ?>
" title="open/close job list"></a>
			<a class="editHandler" href="index.php?action=get&type=clients&id=<?php echo $this->_tpl_vars['clients']['id']; ?>
&r=form"><?php echo ((is_array($_tmp=$this->_tpl_vars['clients']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</a>

			<div class="options" style="float:right"><a class="editHandler ui-button ui-icon ui-icon-suitcase" href="index.php?action=get&type=jobs&from=clients&id=<?php echo $this->_tpl_vars['clients']['id']; ?>
&r=form&new=1" title="Add new job">+JOB</a></div>
		</div>
	</div>
	<ul class="jobs"></ul>
<div>