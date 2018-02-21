<?php /* Smarty version 2.6.18, created on 2018-02-07 16:30:06
         compiled from contact_form/mathematic.tpl */ ?>
<?php echo $this->_tpl_vars['oLanguage']->GetMessage('check math'); ?>
: <?php echo $this->_tpl_vars['aCapcha']['mathematic_formula']; ?>
 =
<input type="hidden" name="capcha[validation_hash]" value='<?php echo $this->_tpl_vars['aCapcha']['validation_hash']; ?>
' />
<input type="hidden" name="capcha[mathematic_formula]" value='<?php echo $this->_tpl_vars['aCapcha']['mathematic_formula']; ?>
' />
<input type="text" class="form-control grey" name="capcha[result]" value='<?php if ($this->_tpl_vars['aCapcha']['result']): ?><?php echo $this->_tpl_vars['aCapcha']['result']; ?>
<?php endif; ?>' maxlength='5' style="width: 50px !important;display: initial" />