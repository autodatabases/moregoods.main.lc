<?php /* Smarty version 2.6.18, created on 2017-05-24 22:40:28
         compiled from mpanel/customer/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'mpanel/customer/form_add.tpl', 14, false),array('modifier', 'escape', 'mpanel/customer/form_add.tpl', 31, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Customer'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=50%><font color='grey'><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Manager'); ?>
:</font></td>
   <td>
	<?php echo smarty_function_html_options(array('name' => "data[id_manager]",'options' => $this->_tpl_vars['aManagerAssoc'],'selected' => $this->_tpl_vars['aData']['id_manager']), $this);?>

   </td>
  </tr>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Customer Group'); ?>
:</td>
   <td><?php echo smarty_function_html_options(array('name' => "data[id_customer_group]",'options' => $this->_tpl_vars['aCustomerGroupAssoc'],'selected' => $this->_tpl_vars['aData']['id_customer_group']), $this);?>
</td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Customer Type'); ?>
:</td>
   <td><?php echo smarty_function_html_options(array('name' => "data[id_user_customer_type]",'options' => $this->_tpl_vars['aCustomerType'],'selected' => $this->_tpl_vars['aData']['id_user_customer_type']), $this);?>
</td>
  </tr>
 <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Login'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[login] value='<?php echo $this->_tpl_vars['aData']['login']; ?>
' style="width: 100px;">

   <?php if ($this->_tpl_vars['aData']['password_temp']): ?>
	<?php echo $this->_tpl_vars['oLanguage']->getDMessage('Password Temp'); ?>
:
	<input type=text name=data[password_temp] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['password_temp'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" style="width: 100px;" readonly>
	<?php endif; ?>
   </td>
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
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('region'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><?php echo smarty_function_html_options(array('name' => "data[id_region]",'options' => $this->_tpl_vars['aRegionList'],'selected' => $this->_tpl_vars['aData']['id_region']), $this);?>
</td>
  </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('id_geo'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
        <td><?php echo smarty_function_html_options(array('name' => "data[id_geo]",'options' => $this->_tpl_vars['aRegionGeo'],'selected' => $this->_tpl_vars['aData']['id_geo']), $this);?>
</td>
    </tr>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Name'); ?>
:</td>
   <td><input type=text name=data[name] value='<?php echo $this->_tpl_vars['aData']['name']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Discount Static'); ?>
:</td>
   <td><input type=text name=data[discount_static] value='<?php echo $this->_tpl_vars['aData']['discount_static']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Discount Dynamic (%)'); ?>
:</td>
   <td><input type=text name=data[discount_dynamic] value='<?php echo $this->_tpl_vars['aData']['discount_dynamic']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('User Debt'); ?>
:</td>
   <td><input type=text name=data[user_debt] value='<?php echo $this->_tpl_vars['aData']['user_debt']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Country'); ?>
:</td>
   <td><input type=text name=data[country] value='<?php echo $this->_tpl_vars['aData']['country']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('State'); ?>
:</td>
   <td><input type=text name=data[state] value='<?php echo $this->_tpl_vars['aData']['state']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('City'); ?>
:</td>
   <td><input type=text name=data[city] value='<?php echo $this->_tpl_vars['aData']['city']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Zip'); ?>
:</td>
   <td><input type=text name=data[zip] value='<?php echo $this->_tpl_vars['aData']['zip']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Company'); ?>
:</td>
   <td><input type=text name=data[company] value='<?php echo $this->_tpl_vars['aData']['company']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Address'); ?>
:</td>
   <td><input type=text name=data[address] value='<?php echo $this->_tpl_vars['aData']['address']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Email'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   <td><input type=text name=data[email] value='<?php echo $this->_tpl_vars['aData']['email']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Phone'); ?>
:</td>
   <td><input type=text name=data[phone] value='<?php echo $this->_tpl_vars['aData']['phone']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Phone 2'); ?>
:</td>
   <td><input type=text name=data[phone2] value='<?php echo $this->_tpl_vars['aData']['phone2']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Mobile Phone'); ?>
:</td>
   <td><input type=text name=data[phone3] value='<?php echo $this->_tpl_vars['aData']['phone3']; ?>
'></td>
  </tr>
   <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Remarks'); ?>
:</td>
   <td><textarea name=data[remark] rows=3><?php echo $this->_tpl_vars['aData']['remark']; ?>
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
   <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'approved','bChecked' => $this->_tpl_vars['aData']['approved'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
  </tr>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is Test'); ?>
:</td>
   <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_test','bChecked' => $this->_tpl_vars['aData']['is_test'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
  </tr>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Receive Notification'); ?>
:</td>
   <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'receive_notification','bChecked' => $this->_tpl_vars['aData']['receive_notification'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
  </tr>

  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is provider paid'); ?>
:</td>
   <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_provider_paid','bChecked' => $this->_tpl_vars['aData']['is_provider_paid'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
  </tr>
  
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Ip'); ?>
:</td>
   <td><?php echo $this->_tpl_vars['aData']['ip']; ?>
<input type=hidden name=data[ip] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['ip'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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