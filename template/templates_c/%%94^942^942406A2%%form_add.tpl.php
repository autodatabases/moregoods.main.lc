<?php /* Smarty version 2.6.18, created on 2018-02-07 10:44:48
         compiled from mpanel/payment_type/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/payment_type/form_add.tpl', 14, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this,Array())">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('payment Type'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>

<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Url'); ?>
:</td>
   <td><input type=text name=data[url] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Description'); ?>
:</td>
   <td><?php echo $this->_tpl_vars['oAdmin']->getCKEditor('data[description]',$this->_tpl_vars['aData']['description'],700,400); ?>
</td>
</tr>

<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('End Description'); ?>
:</td>
   <td><?php echo $this->_tpl_vars['oAdmin']->getCKEditor('data[end_description]',$this->_tpl_vars['aData']['end_description'],700,400); ?>
</td>
</tr>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_visible.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Num'); ?>
:</td>
   <td><input type=text name=data[num] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['num'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>


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