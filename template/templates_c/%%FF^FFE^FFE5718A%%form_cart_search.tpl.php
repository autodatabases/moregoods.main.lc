<?php /* Smarty version 2.6.18, created on 2017-07-09 12:49:26
         compiled from manager_cart/form_cart_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager_cart/form_cart_search.tpl', 20, false),)), $this); ?>
<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Customer'); ?>
:</td>
		<td><input type=text name=search_login value='<?php echo $_REQUEST['search_login']; ?>
' maxlength=20 style='width:170px'>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Changes For'); ?>
:</td>
		<td><select name='search_changes' style='width:170px;padding: 8px 8px 8px 10px;'>
			<option value='' <?php if ($_REQUEST['search_changes'] == ''): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('All Periods'); ?>
</option>
			<option value='1' <?php if ($_REQUEST['search_changes'] == '1'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('Yestarday'); ?>
</option>
			<option value='7' <?php if ($_REQUEST['search_changes'] == '7'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('Week'); ?>
</option>
			<option value='30' <?php if ($_REQUEST['search_changes'] == '30'): ?>selected<?php endif; ?>
				><?php echo $this->_tpl_vars['oLanguage']->getMessage('Month'); ?>
</option>
			</select></td>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:</td>
		<td>
		<select name='group_id' style='width:130px;padding: 8px 8px 8px 10px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aGroupsG'],'selected' => $_REQUEST['group_id']), $this);?>

			</select>
</td>

	</tr>
		<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage("cart #"); ?>
:</td>
		<td><input type=text name=search_id value='<?php echo $_REQUEST['search_id']; ?>
' maxlength=20 style='width:170px'></td>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Name'); ?>
:</td>
		<td><input type=text name=search_name value='<?php echo $_REQUEST['search_name']; ?>
' maxlength=20 style='width:170px'></td>

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
		<td>По дате</td>
                <td><input class="date" style='width:170px' name=search[datestart] id=datestart type="text" value="<?php echo $_REQUEST['search']['datestart']; ?>
"></td>
                <td>&nbsp; -</td>
                <td><input class="date" style='width:170px' name=search[dateend] id=dateend type="text" value="<?php echo $_REQUEST['search']['dateend']; ?>
"></td>
                <input class="js-date" type="text" name="search[date]" value="" style="display: none;">
                <td><?php echo $this->_tpl_vars['oLanguage']->getMessage('list_of_customer'); ?>
:</td>
		<td style='width:130px;'>
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