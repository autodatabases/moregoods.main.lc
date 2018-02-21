<?php /* Smarty version 2.6.18, created on 2018-01-13 14:16:55
         compiled from addon/mpanel/form_post_date.tpl */ ?>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Date'); ?>
:</td>
	<td><input type=text name=data[post_date] value='<?php echo $this->_tpl_vars['oLanguage']->GetPostDate($this->_tpl_vars['aData']['post_date']); ?>
'></td>
</tr>