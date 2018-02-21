<?php /* Smarty version 2.6.18, created on 2017-05-16 19:38:45
         compiled from addon/mpanel/visible.tpl */ ?>
<?php if ($this->_tpl_vars['aRow']['visible']): ?>
	<font color=green><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Visible'); ?>
</b></font>
<?php else: ?>
	<font color=red><b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Invisible'); ?>
</b></font>
<?php endif; ?>