<?php /* Smarty version 2.6.18, created on 2017-05-16 19:42:30
         compiled from mpanel/log_mail/row_log_mail.tpl */ ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><b><?php echo $this->_tpl_vars['aRow']['address']; ?>
</b> <?php if ($this->_tpl_vars['aRow']['description']): ?><br><?php echo $this->_tpl_vars['aRow']['description']; ?>
<?php endif; ?></td>
<td><b><?php echo $this->_tpl_vars['aRow']['from_email']; ?>
</b><br><?php echo $this->_tpl_vars['aRow']['from_name']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['subject']; ?>
<br>
<?php if ($this->_tpl_vars['aRow']['attach_code']): ?><b><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('attach_code'); ?>
: <?php echo $this->_tpl_vars['aRow']['attach_code']; ?>
</b><?php endif; ?>
</td>
<td><?php echo $this->_tpl_vars['oLanguage']->GetDateTime($this->_tpl_vars['aRow']['post']); ?>
<br><b><?php echo $this->_tpl_vars['oLanguage']->GetDateTime($this->_tpl_vars['aRow']['sent_time']); ?>
</b></td>
<td><?php echo $this->_tpl_vars['aRow']['priority']; ?>
</td>
<td>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_preview.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>