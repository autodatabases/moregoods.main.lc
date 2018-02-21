<?php /* Smarty version 2.6.18, created on 2017-05-24 22:55:47
         compiled from mpanel/manager/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/manager/form_add.tpl', 19, false),array('modifier', 'in_array', 'mpanel/manager/form_add.tpl', 110, false),array('function', 'html_options', 'mpanel/manager/form_add.tpl', 34, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table width=800 border=0 cellspacing=0 cellpadding=0>
<tr>
   <td valign=top>


<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Manager'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Login'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[login] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['login'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<?php if (! $this->_tpl_vars['aData']['id']): ?>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=password name=data[password] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['password'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
   </td>
</tr>
<?php endif; ?>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Name'); ?>
:</td>
   <td><input type=text name=data[name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
 <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('region'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
 <td><?php echo smarty_function_html_options(array('name' => "data[id_region]",'options' => $this->_tpl_vars['aRegionList'],'selected' => $this->_tpl_vars['aData']['id_region']), $this);?>
</td>
</tr>
  <tr>
  <tr>
        <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('customer_group'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
        <td><?php echo smarty_function_html_options(array('name' => "data[id_customer_group]",'options' => $this->_tpl_vars['aCustomerGroup'],'selected' => $this->_tpl_vars['aData']['id_customer_group']), $this);?>
</td>
    </tr>
  <tr>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_image.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Address'); ?>
:</td>
   <td><input type=text name=data[address] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Email'); ?>
:</td>
   <td><input type=text name=data[email] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Phone'); ?>
:</td>
   <td><input type=text name=data[phone] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['phone'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Phone 2'); ?>
:</td>
   <td><input type=text name=data[phone2] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['phone2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Mobile Phone'); ?>
:</td>
   <td><input type=text name=data[phone3] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['phone3'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Skype'); ?>
:</td>
   <td><input type=text name=data[skype] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['skype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Icq'); ?>
:</td>
   <td><input type=text name=data[icq] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['icq'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
</tr>
<tr>
   <td width=50%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Remarks'); ?>
:</td>
   <td><textarea name=data[remark]><?php echo $this->_tpl_vars['aData']['remark']; ?>
</textarea></td>
</tr>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_visible.tpl', 'smarty_include_vars' => array('aData' => $this->_tpl_vars['aData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Approved'); ?>
:</td>
   <td><input type="hidden" name=data[approved] value="0">
   <input type=checkbox name=data[approved] value='1' style="width:22px;" <?php if ($this->_tpl_vars['aData']['approved']): ?>checked<?php endif; ?>></td>
</tr>
<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Has Customers'); ?>
:</td>
   <td><input type="hidden" name=data[has_customer] value="0">
   <input type=checkbox name=data[has_customer] value='1' style="width:22px;"
		<?php if ($this->_tpl_vars['aData']['has_customer'] || ! $this->_tpl_vars['aData']['id']): ?>checked<?php endif; ?>></td>
</tr>
<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is Super Manager'); ?>
:</td>
   <td><input type="hidden" name=data[is_super_manager] value="0">
   <input type=checkbox name=data[is_super_manager] value='1' style="width:22px;" <?php if ($this->_tpl_vars['aData']['is_super_manager']): ?>checked<?php endif; ?>></td>
</tr>
<tr>
    <td>
        <b>Роли</b>
        <hr>
    </td>
    <td></td>
</tr>
<?php $_from = $this->_tpl_vars['aRoles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aRole']):
?>
<tr>
    <td><?php echo $this->_tpl_vars['aRole']['name']; ?>
</td>
    <td><input name="roles[<?php echo $this->_tpl_vars['aRole']['id']; ?>
]" type="checkbox" <?php if (( ((is_array($_tmp=$this->_tpl_vars['aRole']['id'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['aBindedRoles']) : in_array($_tmp, $this->_tpl_vars['aBindedRoles'])) )): ?>checked="checked"<?php endif; ?>></td>
</tr>
<?php endforeach; endif; unset($_from); ?>


</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<input type=hidden name=data[type_] value="manager">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



</td>




</tr>
</table>

</FORM>