<?php /* Smarty version 2.6.18, created on 2017-05-18 17:07:04
         compiled from manager/profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manager/profile.tpl', 34, false),)), $this); ?>
<table class="gm-block-order-filter2" style="background-color: #f8f8f8;border-radius: 5px;margin: 0 0 20px 0;border: 1px solid #5fb7c1; padding: 20px 20px 20px 20px;position: relative;">
	<tr>
   		<td width=30%><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
   		<td><input type=text name=name value='<?php echo $this->_tpl_vars['aUser']['name']; ?>
' maxlength=50 style='width:100%'></td>
  	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your email'); ?>
:</b><?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td style="padding: 10px 0;"><input type=text name=email value='<?php echo $this->_tpl_vars['aUser']['email']; ?>
' maxlength=50 style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your login'); ?>
:</b></td>
		<td style="border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;"><?php echo $this->_tpl_vars['aUser']['login']; ?>
</td>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
		<td style="padding: 10px 0px 10px 0px;">******
		<?php if (! $this->_tpl_vars['bReadOnly']): ?>&nbsp;&nbsp;<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 20px 10px 20px; border-radius: 5px;background-color: white;" 
		href='/?action=user_change_password'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Change Password'); ?>
<?php endif; ?></td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Language po default'); ?>
:</b></td>
		<td valign=center width=280>
				<span style="width: 283px; user-select: none;"></span>
				<select name=data[language] name="id_customer_partner" class="js-uniform" style="width: 280px; height: 40px">
				<option value="ua" <?php if ($this->_tpl_vars['aUser']['language'] == 'ua'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->GetMessage('ukrainian'); ?>
</option>
				<option value="ru" <?php if ($this->_tpl_vars['aUser']['language'] == 'ru'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['oLanguage']->GetMessage('russian'); ?>
</option>
			</select>
		</td>
	</tr>
	<?php if ($this->_tpl_vars['aCanChange']['0']['can_change_customer_partner'] == 1): ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Price Client'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
		<td>
		<?php echo smarty_function_html_options(array('name' => 'id_customer_partner','options' => $this->_tpl_vars['aCustomerPartnerList'],'selected' => $this->_tpl_vars['aUser']['id_customer_partner'],'class' => "js-uniform",'style' => "padding: 10px 10px 10px 10px;width:100%;"), $this);?>

		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Region'); ?>
:<?php if ($this->_tpl_vars['aCanChange']['0']['can_change_region'] == 1): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></b></td>
		<td>
		<?php if ($this->_tpl_vars['aUser']['id_region']): ?>
			<?php $this->assign('iIdRegion', $this->_tpl_vars['aUser']['id_region']); ?>
		<?php else: ?>
			<?php $this->assign('iIdRegion', $_REQUEST['data']['id_region']); ?>
		<?php endif; ?>
		<?php echo smarty_function_html_options(array('name' => 'id_region','options' => $this->_tpl_vars['aRegionList'],'selected' => $this->_tpl_vars['iIdRegion'],'class' => "js-uniform",'style' => "padding: 10px 10px 10px 10px;width:100%;"), $this);?>

		</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:<?php if ($this->_tpl_vars['aCanChange']['0']['can_change_group'] == 1): ?><?php echo $this->_tpl_vars['sZir']; ?>
<?php endif; ?></b></td>
		<td>
		<?php if ($this->_tpl_vars['iCustomerGroup']): ?>
			<?php $this->assign('iIdGroup', $this->_tpl_vars['iCustomerGroup']); ?>
		<?php else: ?>
			<?php $this->assign('iIdGroup', $_REQUEST['group_id']); ?>
		<?php endif; ?>
		<?php echo smarty_function_html_options(array('name' => 'id_group','options' => $this->_tpl_vars['aGroupsG'],'selected' => $this->_tpl_vars['iIdGroup'],'class' => "js-uniform",'style' => "padding: 10px 10px 10px 10px;width:100%;"), $this);?>

		</td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
		<td><textarea name=address style='width:100%'><?php echo $this->_tpl_vars['aUser']['address']; ?>
</textarea></td>
	</tr>

	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
		<td><input type=text name=phone value='<?php echo $this->_tpl_vars['aUser']['phone']; ?>
' maxlength=50 style='width:100%'></td>
	</tr>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('CustomerRemarks'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</b></td>
		<td><textarea name=remark style='width:100%'><?php echo $this->_tpl_vars['aUser']['remark']; ?>
</textarea></td>
	</tr>
</table>