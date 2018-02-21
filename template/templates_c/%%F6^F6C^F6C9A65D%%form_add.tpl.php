<?php /* Smarty version 2.6.18, created on 2018-02-19 23:05:01
         compiled from addon/mpanel/locale_global/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/locale_global/form_add.tpl', 40, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this,Array(<?php echo $this->_tpl_vars['sFCKArray']; ?>
))">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Translation'); ?>
 - <?php echo $this->_tpl_vars['sLanguageTitle']; ?>
</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<?php $_from = $this->_tpl_vars['aMap']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sFieldName'] => $this->_tpl_vars['sFieldType']):
?>
<?php if ($this->_tpl_vars['sFieldType'] == 'textarea'): ?>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage($this->_tpl_vars['sFieldName']); ?>
:</td>
				<td><textarea name=data[<?php echo $this->_tpl_vars['sFieldName']; ?>
]><?php echo $this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]; ?>
</textarea></td>
			</tr>
<?php elseif ($this->_tpl_vars['sFieldType'] == 'editor'): ?>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage($this->_tpl_vars['sFieldName']); ?>
:</td>
				<td><?php echo $this->_tpl_vars['oAdmin']->getFCKEditor("data_".($this->_tpl_vars['sFieldName']),$this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]); ?>
</td>
			</tr>
			<tr><td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Use code html'); ?>
:</td>
			    <td><input type="hidden" name=data[use_code_html] value="0">
			    <input type=checkbox name=data[use_code_html] value='1' style="width:22px;"></td>
			</tr>
			<tr><td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Translation html'); ?>
:</td>
			    <td><textarea style="width: 700px;height: 300px;" name=data[<?php echo $this->_tpl_vars['sFieldName']; ?>
_html]><?php echo $this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']]; ?>
</textarea></td>
			</tr>
<?php elseif ($this->_tpl_vars['sFieldType'] == 'checkbox'): ?>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage($this->_tpl_vars['sFieldName']); ?>
:</td>
				<td>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => $this->_tpl_vars['sFieldName'],'bChecked' => $this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</td>
			</tr>
<?php else: ?>
			<tr>
				<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage($this->_tpl_vars['sFieldName']); ?>
:</td>
				<td><input name=data[<?php echo $this->_tpl_vars['sFieldName']; ?>
] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData'][$this->_tpl_vars['sFieldName']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
			</tr>
<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[i] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['i'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

<input type=hidden name=table_name value="<?php echo $this->_tpl_vars['sTableName']; ?>
">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</FORM>