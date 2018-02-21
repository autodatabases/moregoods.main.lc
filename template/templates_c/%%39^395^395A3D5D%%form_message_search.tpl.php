<?php /* Smarty version 2.6.18, created on 2018-02-19 23:26:16
         compiled from message/form_message_search.tpl */ ?>
<script src="/js/popcalendar.js"></script>

<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('From'); ?>
:</td>
		<td><input type=text name=search_from value='<?php echo $_REQUEST['search_from']; ?>
' maxlength=20 style='width:176px'></td>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('To'); ?>
:</td>
		<td><input type=text name=search_to value='<?php echo $_REQUEST['search_to']; ?>
' maxlength=20 style='width:176px'></td>
	</tr>
	
</table>