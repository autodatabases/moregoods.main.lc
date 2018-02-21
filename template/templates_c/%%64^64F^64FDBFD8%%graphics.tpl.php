<?php /* Smarty version 2.6.18, created on 2017-05-15 18:45:45
         compiled from addon/capcha/graphics.tpl */ ?>
<input type="text" name="capcha[result]" value='<?php if ($this->_tpl_vars['aCapcha']['result']): ?><?php echo $this->_tpl_vars['aCapcha']['result']; ?>
<?php endif; ?>' maxlength='5'
	style="width: 50px;" />
<input type="hidden" name="capcha[type]" value='<?php echo $this->_tpl_vars['aCapcha']['sTypeCapcha']; ?>
' />
<img id="capcha" src="/<?php echo $this->_tpl_vars['aCapcha']['sGraphCapcha']; ?>
" />
<a onclick="reloadimg()"><img width="22" height="22" border="0" src="/image/design/hip_reload.gif"></a>