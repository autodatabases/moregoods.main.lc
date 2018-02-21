<?php /* Smarty version 2.6.18, created on 2018-01-13 14:52:47
         compiled from mpanel/banner/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/banner/form_add.tpl', 14, false),array('function', 'html_options', 'mpanel/banner/form_add.tpl', 22, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);'onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Caorusel'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('link'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[link] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('brand'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><?php echo smarty_function_html_options(array('name' => "data[id_brand]",'options' => $this->_tpl_vars['aBrandList'],'selected' => $this->_tpl_vars['aData']['id_brand']), $this);?>
</td>
</tr>
    <tr>
        <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Brand_group'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
        <td><?php echo smarty_function_html_options(array('name' => "data[id_brand_group]",'options' => $this->_tpl_vars['aGroupList'],'selected' => $this->_tpl_vars['aData']['id_brand_group']), $this);?>
</td>
    </tr>
 <tr>
  <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('is_main'); ?>
:</td>
  <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_main','bChecked' => $this->_tpl_vars['aData']['is_main'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
 </tr>
 <tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('sort'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[sort] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['sort'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mpanel/banner/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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