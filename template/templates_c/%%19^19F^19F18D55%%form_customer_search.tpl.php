<?php /* Smarty version 2.6.18, created on 2017-07-09 12:45:36
         compiled from manager/form_customer_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/form_customer_search.tpl', 12, false),)), $this); ?>
<table width=100% border=0 class="gm-block-order-filter ">
	<tr>
		<td>ID:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[id_user] value='<?php echo $_REQUEST['search']['id_user']; ?>
' maxlength=20 ></td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('CustName'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[name] value='<?php echo $_REQUEST['search']['name']; ?>
' maxlength=20 ></td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'>
			<select name=search[group_id] style='width:130px;padding: 8px 8px 8px 10px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aGroupsG'],'selected' => $_REQUEST['search']['group_id']), $this);?>

			</select>
		</td>

	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[login] value='<?php echo $_REQUEST['search']['login']; ?>
' maxlength=20 ></td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[phone] value='<?php echo $_REQUEST['search']['phone']; ?>
' maxlength=20 ></td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Canal'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'>
			<select name=search[type_id] style='width:130px;padding: 8px 8px 8px 10px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aTypeG'],'selected' => $_REQUEST['search']['type_id']), $this);?>

			</select>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('list_of_customer'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'>
		<select name=search_list_cust style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>All Users</option>
		<?php $_from = $this->_tpl_vars['aListManager']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aKey'] => $this->_tpl_vars['aRow']):
?>
			<option value='<?php echo $this->_tpl_vars['aKey']; ?>
' 
			<?php if ($this->_tpl_vars['aKey'] == $_REQUEST['search_list_cust']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aRow']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
</table>