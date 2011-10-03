<?php /* Smarty version 2.6.26, created on 2011-09-29 08:07:40
         compiled from approval.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strtolower', 'approval.html', 11, false),)), $this); ?>
	<style>
		.content { font-family: arial;font-size:12px;}
		.header { text-align:left}
		.approve { color:green;font-weight:bold}
		.decline { color:red;font-weight:bold}
		.data	{ font-size:12px}
	</style>
	<div class="content">
		<h2>Please approve or decline &quot;<?php echo $this->_tpl_vars['item']['title']; ?>
&quot;</h2>
		<blockquote>
			You have been assigned as the contact to test and approve that this <?php echo ((is_array($_tmp=$this->_tpl_vars['type'])) ? $this->_run_mod_handler('strtolower', true, $_tmp) : strtolower($_tmp)); ?>
 has been completed as specified.  Once you have verified, please re-visit this email and click the links below as to whether or not you <b>approve</b> or <b>decline</b> that this <?php echo ((is_array($_tmp=$this->_tpl_vars['type'])) ? $this->_run_mod_handler('strtolower', true, $_tmp) : strtolower($_tmp)); ?>
 is completed.
		</blockquote>
		<p>If you decline, you will have the opportunity to make comments as to why.</p>
		<h2><?php echo $this->_tpl_vars['type']; ?>
</h2>
		<table width="100%" class="data">
			<tr>
				<th class="header"><b>Name</b></td>
				<td class="header"><b>Description</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['item']['title']; ?>
</td><td><?php echo $this->_tpl_vars['item']['content']; ?>
</td>
			</tr>
			<tr>
				<Td colspan="2"><hr></td>
			</tr>
		</table>
		<h2>Notes</h2>
		<table width="100%" class="data">
			<?php $_from = $this->_tpl_vars['notes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['n']):
?>
			<?php if (($this->_foreach['n']['iteration'] <= 1)): ?>
			<tr>
				<Td><b>Date</b></td><td><b>Title</b></td><td><b>Content</b></td>
			</tr>
			<?php endif; ?>
			<tr>
				<td style="width:130px"><?php echo $this->_tpl_vars['n']['updated']; ?>
</td><td style="width:200px"><?php echo $this->_tpl_vars['n']['title']; ?>
</td><td><?php echo $this->_tpl_vars['n']['note']; ?>
</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
		<hr>
		<table width="100%">
			<tr>
				<td class="approve"><a href="<?php echo $this->_tpl_vars['approve_url']; ?>
" class="approve">Approve</a></td>
				<td class="decline"><a href="<?php echo $this->_tpl_vars['decline_url']; ?>
" class="decline">Decline</a></td>
			</tr>
		</table>
	</div>