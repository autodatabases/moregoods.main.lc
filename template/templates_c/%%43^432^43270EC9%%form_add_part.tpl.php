<?php /* Smarty version 2.6.18, created on 2018-02-19 23:04:36
         compiled from addon/mpanel/drop_down/form_add_part.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/drop_down/form_add_part.tpl', 3, false),)), $this); ?>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
	<td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Code'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
	<td><input type=text name=data[code] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['code'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Order Num'); ?>
:</td>
	<td><input type=text name=data[num] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['num'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Code is URL'); ?>
:</td>
	<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'link','bChecked' => $this->_tpl_vars['aData']['link'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Invisible Map'); ?>
:</td>
	<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'invisible_map','bChecked' => $this->_tpl_vars['aData']['invisible_map'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
</tr>
<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is Menu Visible'); ?>
:</td>
   <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_menu_visible','bChecked' => $this->_tpl_vars['aData']['is_menu_visible'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Title'); ?>
:</td>
	<td><input type=text name=data[title] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Page Description'); ?>
:</td>
	<td><textarea name=data[page_description]><?php echo $this->_tpl_vars['aData']['page_description']; ?>
</textarea></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Page Keywords'); ?>
:</td>
	<td><textarea name=data[page_keyword]><?php echo $this->_tpl_vars['aData']['page_keyword']; ?>
</textarea></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Width Limit'); ?>
:</td>
	<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'width_limit','bChecked' => $this->_tpl_vars['aData']['width_limit'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
</tr>
<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Without link'); ?>
:</td>
	<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'only_childs','bChecked' => $this->_tpl_vars['aData']['only_childs'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
</tr>

<tr>
	<td width="100%"><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is Featured'); ?>
:</td>
	<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_featured','bChecked' => $this->_tpl_vars['aData']['is_featured'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
</tr>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_visible.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>