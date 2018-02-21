<?php /* Smarty version 2.6.18, created on 2018-02-19 23:03:03
         compiled from customer/profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'customer/profile.tpl', 79, false),)), $this); ?>
<table class="gm-block-order-filter2 no-mobile" 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 54px;
    position: relative;">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your login'); ?>
:
		<?php if ($this->_tpl_vars['bLoginChange']): ?><?php echo $this->_tpl_vars['oLanguage']->getContextHint('customer_account_login_change'); ?>
<?php endif; ?></td>
		<td style="border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;"><?php echo $this->_tpl_vars['aUser']['login']; ?>
&nbsp;&nbsp;
				</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your email'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td style="padding: 10px 0;"><input type=text name=data[email] value='<?php echo $this->_tpl_vars['aUser']['email']; ?>
' maxlength=50 style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Password'); ?>
:</td>
		<td style="padding: 10px 0px 10px 0px;">******
		<?php if (! $this->_tpl_vars['bReadOnly']): ?>&nbsp;&nbsp;<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 20px 10px 20px; border-radius: 5px;background-color: white;" 
		href='/?action=user_change_password'><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Change Password'); ?>
<?php endif; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Your manager'); ?>
:</td>
		<td style="padding: 10px 0px 10px 0px;"> <?php echo $this->_tpl_vars['aAuthUser']['manager_login']; ?>

&nbsp;
	<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 44px 10px 44px; border-radius: 5px;background-color: white;" 
	href='/?action=message_compose&compose_to=<?php echo $this->_tpl_vars['aAuthUser']['manager_login']; ?>
'
		><?php echo $this->_tpl_vars['oLanguage']->getMessage('Send message to manager'); ?>
</a>

		</td>
	</tr>
	
	


	<tr>
		<td colspan=2><i><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Delivery info'); ?>
</i><hr /></td>
	</tr>
    <script type="text/javascript" src="/js/user.js?2"></script>
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('FLName'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td valign=center width=280>
		<input type=text name=data[name] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>

	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('City'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td valign=center width=280>
		<input type=text name=data[city] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['city'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
  	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Address'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td valign=center width=280>
		<input type=text name=data[address] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['address'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%'
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Phone'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td valign=center width=280>
		<input type=text name=data[phone] value='<?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['phone'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
' style='width:100%' id='user_phone' placeholder="(___)___ __ __"
		<?php if ($this->_tpl_vars['bReadOnly']): ?>readonly<?php endif; ?>></td>
	</tr>
	
	<tr>
		<td valign=top><?php echo $this->_tpl_vars['oLanguage']->GetMessage('CustomerRemarks'); ?>
:</td>
		<td><textarea name=data[remark] style='width:100%' <?php if ($this->_tpl_vars['bReadOnly']): ?>disabled<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['aUser']['remark'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</textarea></td>
	</tr>
	
	
</table>