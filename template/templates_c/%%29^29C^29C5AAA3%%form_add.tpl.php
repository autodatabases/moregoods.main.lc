<?php /* Smarty version 2.6.18, created on 2018-01-13 12:48:01
         compiled from mpanel/ec_products/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'mpanel/ec_products/form_add.tpl', 15, false),array('modifier', 'escape', 'mpanel/ec_products/form_add.tpl', 38, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('products'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('brand group'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td>
   <?php echo smarty_function_html_options(array('name' => "data[id_brand_group]",'options' => $this->_tpl_vars['aBrandGroupList'],'selected' => $this->_tpl_vars['aData']['id_brand_group']), $this);?>

  </td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('brand'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td>
   <?php echo smarty_function_html_options(array('name' => "data[id_brand]",'options' => $this->_tpl_vars['aBrandList'],'selected' => $this->_tpl_vars['aData']['id_brand']), $this);?>

  </td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('vt'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td>
   <?php echo smarty_function_html_options(array('name' => "data[id_vt]",'options' => $this->_tpl_vars['aVtList'],'selected' => $this->_tpl_vars['aData']['id_vt']), $this);?>

  </td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('type'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td>
   <?php echo smarty_function_html_options(array('name' => "data[id_type]",'options' => $this->_tpl_vars['aTypeList'],'selected' => $this->_tpl_vars['aData']['id_type']), $this);?>

  </td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('short_name'); ?>
:</td>
   <td><input type=text name=data[short_name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['short_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('art'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[art] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['art'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('barcode'); ?>
:</td>
   <td><input type=text name=data[barcode] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['barcode'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('unit'); ?>
:</td>
   <td><input type=text name=data[unit] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['unit'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('weight'); ?>
:</td>
   <td><input type=text name=data[weight] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['weight'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('volume'); ?>
:</td>
   <td><input type=text name=data[volume] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['volume'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('pack_qty'); ?>
:</td>
   <td><input type=text name=data[pack_qty] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['pack_qty'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'],'sFieldName' => 'img')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'],'sFieldName' => 'img2')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('id_parent'); ?>
:</td>
   <td><input type=text name=data[id_parent] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id_parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('check'); ?>
:</td>
   <td><input type=text name=data[check_] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['check_'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('select_type'); ?>
:</td>
   <td><input type=text name=data[select_type] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['select_type'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('order'); ?>
:</td>
   <td><input type=text name=data[sort] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['sort'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_visible.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</FORM>