<?php /* Smarty version 2.6.18, created on 2018-02-15 09:11:31
         compiled from mpanel/ec_vid/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'mpanel/ec_vid/form_add.tpl', 13, false),array('modifier', 'escape', 'mpanel/ec_vid/form_add.tpl', 21, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Catalog'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('short_name'); ?>
:</td>
   <td><input type=text name=data[short_name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['short_name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('level'); ?>
:</td>
   <td><input type=text name=data[level] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['level'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('id_parent'); ?>
:</td>
   <td><input type=text name=data[id_parent] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id_parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('col'); ?>
:</td>
   <td><input type=text name=data[col] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['col'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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