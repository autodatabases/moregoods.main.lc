<?php /* Smarty version 2.6.18, created on 2017-05-16 19:42:38
         compiled from mpanel/log_mail/preview.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/log_mail/preview.tpl', 15, false),)), $this); ?>
<TABLE class=itemslist>
<tr>
	<th colspan=2><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Email Preview'); ?>
</th>
</tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Id'); ?>
:</td><td><?php echo $this->_tpl_vars['aData']['id']; ?>
</td></tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('From'); ?>
:</td><td><?php echo $this->_tpl_vars['aData']['from']; ?>
</td></tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('From Name'); ?>
:</td><td><?php echo $this->_tpl_vars['aData']['from_name']; ?>
</td></tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Address'); ?>
:</td><td><?php echo $this->_tpl_vars['aData']['address']; ?>
</td></tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Subject'); ?>
:</td><td><?php echo $this->_tpl_vars['aData']['subject']; ?>
</td></tr>
<tr><td></td><td><?php echo $this->_tpl_vars['aData']['body']; ?>
</td></tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Post'); ?>
:</td><td><?php echo $this->_tpl_vars['oLanguage']->GetDateTime($this->_tpl_vars['aData']['post']); ?>
</td></tr>
<tr><td><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Sent'); ?>
:</td><td><?php echo $this->_tpl_vars['oLanguage']->GetDateTime($this->_tpl_vars['aData']['sent_time']); ?>
</td></tr>
</table><br>
<input type=button value='<?php echo $this->_tpl_vars['oLanguage']->getDMessage('<< Return'); ?>
'
 onClick=" xajax_process_browse_url('?<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'); return false; " class=submit_button>