<?php /* Smarty version 2.6.18, created on 2018-01-13 13:10:23
         compiled from mpanel/ec_price/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/ec_price/form_add.tpl', 13, false),array('function', 'html_options', 'mpanel/ec_price/form_add.tpl', 18, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('price'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('product'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td><input type=text name=data[id_product] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id_product'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('region'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td>
   <?php echo smarty_function_html_options(array('name' => "data[id_region]",'options' => $this->_tpl_vars['aRegionList'],'selected' => $this->_tpl_vars['aData']['id_region']), $this);?>

  </td>
</tr>

<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('price'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[price] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['price'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
    <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('id_customer_group'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
    <td><input type=text name=data[id_customer_group] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id_customer_group'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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