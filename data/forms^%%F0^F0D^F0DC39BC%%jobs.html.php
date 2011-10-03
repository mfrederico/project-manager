<?php /* Smarty version 2.6.26, created on 2011-09-29 15:23:01
         compiled from jobs.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'jobs.html', 4, false),array('modifier', 'nl2br', 'jobs.html', 13, false),)), $this); ?>
<li id="jobs_<?php echo $this->_tpl_vars['jobs']['id']; ?>
" class="jobs_widget">
	<div>
		<div style="clear:both;height:25px" class="ui-state-default">
			<a href="#<?php echo $this->_tpl_vars['jobs']['id']; ?>
" class="ui-button ui-icon ui-icon-triangle-1-e openboth"> > </a><a href="index.php?action=get&type=jobs&jobs_id=<?php echo $this->_tpl_vars['jobs']['id']; ?>
&from=clients&id=<?php echo $_GET['id']; ?>
&r=form" class="editHandler" style="line-height:25px;margin-left:7px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['jobs']['title'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</a>
			<div style="float:right">
				<a class="ui-button ui-icon ui-icon-note editHandler" href="index.php?action=get&type=tasks&from=jobs&id=<?php echo $this->_tpl_vars['jobs']['id']; ?>
&new=1&r=form" title="Add task"></a>
			</div>
			<div style="float:right">
				<a class="ui-button ui-icon ui-icon-comment editHandler" href="index.php?action=get&type=notes&from=jobs&id=<?php echo $this->_tpl_vars['jobs']['id']; ?>
&new=1&r=form" title="Add note"></a>
			</div>
		</div>
		<div class="label ui-state-highlight">
			<small><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['jobs']['content'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</small>
			<ul class="notes ui-helper-hidden" style="margin-top:7px;"></ul>
			<ul class="tasks ui-helper-hidden" style="margin-top:7px;"></ul>
		</div>
	</div>
</li>