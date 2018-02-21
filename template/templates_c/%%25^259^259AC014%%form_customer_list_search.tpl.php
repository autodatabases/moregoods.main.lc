<?php /* Smarty version 2.6.18, created on 2017-07-09 10:57:45
         compiled from manager/form_customer_list_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/form_customer_list_search.tpl', 12, false),)), $this); ?>
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

		<td nowrap><?php echo $this->_tpl_vars['oLanguage']->getMessage('InList'); ?>
:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'>
			<select name=search[inlist] style='width:130px;padding: 8px 8px 8px 10px;'>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aInList'],'selected' => $_REQUEST['search']['inlist']), $this);?>

			</select>
		</td>
	</tr>
</table>