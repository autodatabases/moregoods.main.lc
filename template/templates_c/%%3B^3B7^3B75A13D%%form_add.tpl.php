<?php /* Smarty version 2.6.18, created on 2018-02-07 16:30:55
         compiled from mpanel/content_editor/form_add.tpl */ ?>
<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form style="width:705px;">
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Content editor'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
	<td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Select page for edit'); ?>
:</td>
	<td>
	<select name=data[id] id='drop_down_id' style="width: 500px;"
		onChange="xajax_process_browse_url('?action=content_editor_change&data[id]='+$('#drop_down_id').val());">
		<?php $_from = $this->_tpl_vars['aDropDown']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
			<option value='<?php echo $this->_tpl_vars['aItem']['id']; ?>
' <?php if ($this->_tpl_vars['aItem']['id'] == $this->_tpl_vars['aData']['id']): ?>selected<?php endif; ?>>
			<?php if ($this->_tpl_vars['aItem']['level'] > 1): ?>&nbsp;&nbsp;<?php endif; ?><?php if ($this->_tpl_vars['aItem']['level'] > 2): ?>&nbsp;&nbsp;<?php endif; ?>
			<?php echo $this->_tpl_vars['aItem']['name']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
	</select>
	</td>
</tr>
<tr>
	<td colspan=2 id='text_editor_id'>
	<?php echo $this->_tpl_vars['sTextEditor']; ?>

	</td>
</tr>
<?php if ($this->_tpl_vars['oLanguage']->GetConstant('mpanel:is_left_bottom_text_active')): ?>
<tr>
	<td colspan=2>
<hr>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_text_left_visible','bChecked' => $this->_tpl_vars['aData']['is_text_left_visible'],'sOnClick' => "$('#text_left_editor_id').toggle();")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('is_text_left_visible'); ?>
</b>

	<span id='text_left_editor_id' <?php if (! $this->_tpl_vars['aData']['is_text_left_visible']): ?>style="display: none;"<?php endif; ?>>
		<?php echo $this->_tpl_vars['sTextLeftEditor']; ?>

	</span>
	</td>
</tr>

<tr>
	<td colspan=2 >
	<hr>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_text_bottom_visible','bChecked' => $this->_tpl_vars['aData']['is_text_bottom_visible'],'sOnClick' => "$('#text_bottom_editor_id').toggle();")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<b><?php echo $this->_tpl_vars['oLanguage']->getDMessage('is_text_bottom_visible'); ?>
</b>

	<span id='text_bottom_editor_id' <?php if (! $this->_tpl_vars['aData']['is_text_bottom_visible']): ?>style="display: none;"<?php endif; ?>>
		<?php echo $this->_tpl_vars['sTextBottomEditor']; ?>

	</span>
	</td>
</tr>

<?php endif; ?>
</table>

</td></tr>
</table>

<input type=hidden name=action value=content_editor_apply>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'],'bHideReturn' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</FORM>