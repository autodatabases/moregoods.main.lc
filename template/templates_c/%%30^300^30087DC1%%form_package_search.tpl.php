<?php /* Smarty version 2.6.18, created on 2017-07-09 12:39:02
         compiled from manager/form_package_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/form_package_search.tpl', 12, false),)), $this); ?>
<table style="width:100%;" border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage("CartPackage #"); ?>
:</td>
		<td><input type=text name=search[id] value='<?php echo $_REQUEST['search']['id']; ?>
' maxlength=20 style='width:130px'></td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Customer'); ?>
:</td>
		<td><input type=text name=search_login value='<?php echo $_REQUEST['search_login']; ?>
' maxlength=20 style='width:130px;padding: 8px 8px 8px 10px;'></td>
		
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:</td>
		<td>
		<select name='group_id' style='width:130px;padding: 8px 8px 8px 10px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aGroupsG'],'selected' => $_REQUEST['group_id']), $this);?>

			</select>
</td>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Status'); ?>
:</td>
		<td><select name='search_order_status' style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''><?php echo $this->_tpl_vars['oLanguage']->getMessage('All'); ?>
</option>
			<option value='new' <?php if ($_REQUEST['search_order_status'] == 'new'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('new'); ?>
</option>
			<option value='pending' <?php if ($_REQUEST['search_order_status'] == 'pending'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('pending'); ?>
</option>
			<option value='work' <?php if ($_REQUEST['search_order_status'] == 'work'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('work'); ?>
</option>
			<option value='end' <?php if ($_REQUEST['search_order_status'] == 'end'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('end'); ?>
</option>
			<option value='refused' <?php if ($_REQUEST['search_order_status'] == 'refused'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('refused'); ?>
</option>
			</select></td>
						
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('is_payed'); ?>
:</td>
		<td><select name='status_liq' style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''><?php echo $this->_tpl_vars['oLanguage']->getMessage('All'); ?>
</option>
			<option value='1' <?php if ($_REQUEST['status_liq'] == '1'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('is_payed'); ?>
</option>
			<option value='0' <?php if ($_REQUEST['status_liq'] == '0'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('not_payed'); ?>
</option>
			</select></td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Autor'); ?>
:</td>
		<td>
		<select name=id_autor style='width:130px;padding: 8px 8px 8px 10px;'>
		<?php $_from = $this->_tpl_vars['aAutors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aRow']):
?>
			<option value='<?php echo $this->_tpl_vars['aRow']['id_autor']; ?>
' <?php if ($this->_tpl_vars['aRow']['id_autor'] == $_REQUEST['id_autor']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aRow']['login']; ?>
 &nbsp;&nbsp; <?php echo $this->_tpl_vars['aRow']['name']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('list_of_customer'); ?>
:</td>
		<td>
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