<?php /* Smarty version 2.6.18, created on 2018-02-07 19:49:49
         compiled from addon/mpanel/admin/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'addon/mpanel/admin/form_add.tpl', 15, false),array('modifier', 'escape', 'addon/mpanel/admin/form_add.tpl', 66, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 <?php echo $this->_tpl_vars['oLanguage']->getDMessage('Admin'); ?>

 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Type'); ?>
:</td>
   <td>
   	<?php echo smarty_function_html_options(array('name' => "data[type_]",'values' => $this->_tpl_vars['aType'],'output' => $this->_tpl_vars['aType'],'selected' => $this->_tpl_vars['aData']['type_']), $this);?>

   </td>
   <?php if ($this->_tpl_vars['bHasLanguageAccessRules']): ?>
       <td rowspan="4">
       			<?php echo $this->_tpl_vars['oLanguage']->getDMessage('Languages denied'); ?>
:<br/>
       			<?php echo smarty_function_html_options(array('name' => "data[id_language][]",'options' => $this->_tpl_vars['aLocaleAll'],'selected' => $this->_tpl_vars['aLocaleDenied'],'style' => "width:".($this->_tpl_vars['iAdminLangSelectWidth']),'multiple' => 'multiple','size' => $this->_tpl_vars['iAdminLangCount']), $this);?>
</td>
      </tr>
	<?php endif; ?>
  <tr>
   <td width=100%><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Login'); ?>
:</td>
   <td><input type=text name=data[login] value='<?php echo $this->_tpl_vars['aData']['login']; ?>
' ></td>
  </tr>
<?php if ('4.5.0' == $this->_tpl_vars['oLanguage']->GetConstant('module_version:aadmin')): ?>
  <tr>
  	<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Password'); ?>
:</td>
  	<td>
	  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		     <td><select name=data[pwd_type] style='width: 80px'>
					<option value="text">Text</option>
			     	<option value="md5">MD5</option>
				</select></td>
		     <td><input type=password name=data[passwd] value='<?php echo $this->_tpl_vars['aData']['passwd']; ?>
' style='width: 205px'></td>
		  </tr>
		</table>
  	</td>
  </tr>
<?php endif; ?>
<?php if ('4.5.1' == $this->_tpl_vars['oLanguage']->GetConstant('module_version:aadmin')): ?>
	<?php if (! $this->_tpl_vars['aData']['id']): ?>
<tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Password'); ?>
:</td>
   <td><input type='password' name='data[password]' value='' /></td>
</tr>
	<?php endif; ?>
<?php endif; ?>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('FLName'); ?>
:</td>
   <td><input type=text name=data[name] value='<?php echo $this->_tpl_vars['aData']['name']; ?>
'></td>
  </tr>
  <tr>
   <td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Is base access denied'); ?>
:</td>
   <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/form_checkbox.tpl', 'smarty_include_vars' => array('sFieldName' => 'is_base_denied','bChecked' => $this->_tpl_vars['aData']['is_base_denied'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
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