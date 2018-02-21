<?php /* Smarty version 2.6.18, created on 2017-05-15 18:46:26
         compiled from addon/capcha/mathematic.tpl */ ?>
<b><?php echo $this->_tpl_vars['aCapcha']['mathematic_formula']; ?>
 = </b>
<input type="hidden" name="capcha[validation_hash]" value='<?php echo $this->_tpl_vars['aCapcha']['validation_hash']; ?>
' />
<input type="hidden" name="capcha[mathematic_formula]" value='<?php echo $this->_tpl_vars['aCapcha']['mathematic_formula']; ?>
' />
<input type="text" name="capcha[result]" value='<?php if ($this->_tpl_vars['aCapcha']['result']): ?><?php echo $this->_tpl_vars['aCapcha']['result']; ?>
<?php endif; ?>' maxlength='5'
	style="width: 50px;" />