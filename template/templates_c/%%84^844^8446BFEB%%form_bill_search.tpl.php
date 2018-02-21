<?php /* Smarty version 2.6.18, created on 2017-07-09 13:05:55
         compiled from manager/form_bill_search.tpl */ ?>
<table width=700 border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('date_from'); ?>
:</td>
		<td><input type=text class="date" name=search[date_from] id=datestart value='<?php echo $_REQUEST['search']['date_from']; ?>
' maxlength=20 style='width:110px'>
		</td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('date_to'); ?>
:</td>
		<td><input type=text class="date" name=search[date_to] id=dateend value='<?php echo $_REQUEST['search']['date_to']; ?>
' maxlength=20 style='width:110px'>
		</td>

	

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('method'); ?>
:</td>
		<td><select name=search[method] style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>All</option>
		<?php $_from = $this->_tpl_vars['aMethod']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aKey'] => $this->_tpl_vars['aRow']):
?>
			<option value='<?php echo $this->_tpl_vars['aRow']; ?>
' <?php if ($this->_tpl_vars['aRow'] == $_REQUEST['search']['method']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aRow']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr>	
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('id_cart_package'); ?>
:</td>
		<td><input type=text  name=search[id_cart_package] value='<?php echo $_REQUEST['search']['id_cart_package']; ?>
' maxlength=20 style='width:110px'>
		</td>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Customer'); ?>
:</td>
		<td><input type=text  name=search[name] value='<?php echo $_REQUEST['search']['name']; ?>
' maxlength=20 style='width:110px'>
		</td>

		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('customer_group'); ?>
:</td>
		<td><select name=search[customer_group] style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>All</option>
		<?php $_from = $this->_tpl_vars['aGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aKey'] => $this->_tpl_vars['aRow']):
?>
			<option value='<?php echo $this->_tpl_vars['aRow']; ?>
' <?php if ($this->_tpl_vars['aRow'] == $_REQUEST['search']['customer_group']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aRow']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('list_of_customer'); ?>
:</td>
		<td>
		<select name=search_list_cust style='width:111px;padding: 8px 8px 8px 10px;'>
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
