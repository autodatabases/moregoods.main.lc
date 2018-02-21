<?php /* Smarty version 2.6.18, created on 2017-05-16 19:40:01
         compiled from hint/customer.tpl */ ?>
<?php if ($this->_tpl_vars['aData']['price_type'] == 'margin'): ?>
	<?php $this->assign('sLoginColor', 'brown'); ?>
<?php else: ?>
	<?php $this->assign('sLoginColor', 'gray'); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['aData']['vip']): ?>
	<?php $this->assign('sLoginColor', 'red'); ?>
<?php endif; ?>
<span onmouseover="$('#<?php echo $this->_tpl_vars['aData']['login']; ?>
<?php echo $this->_tpl_vars['aData']['id']; ?>
').toggle();"
	onmouseout="$('#<?php echo $this->_tpl_vars['aData']['login']; ?>
<?php echo $this->_tpl_vars['aData']['id']; ?>
').toggle();"><a href="#"
	onclick="return false"
	style=" color: <?php echo $this->_tpl_vars['sLoginColor']; ?>
;"
	><?php echo $this->_tpl_vars['aData']['login']; ?>
<?php if ($this->_tpl_vars['aData']['name']): ?> - <?php echo $this->_tpl_vars['aData']['name']; ?>
<?php endif; ?></a> <?php if ($this->_tpl_vars['aData']['login_parent']): ?><font color=green><b><?php echo $this->_tpl_vars['aData']['login_parent']; ?>
</b></font><?php endif; ?>
<div align=left style="display: none; width: 350px;" class="tip_div" id="<?php echo $this->_tpl_vars['aData']['login']; ?>
<?php echo $this->_tpl_vars['aData']['id']; ?>
">
	<p><b><font color="<?php echo $this->_tpl_vars['sLoginColor']; ?>
"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</b> <?php echo $this->_tpl_vars['aData']['login']; ?>
</font>
	<?php if ($this->_tpl_vars['aData']['login_parent']): ?><?php echo $this->_tpl_vars['oLanguage']->getMessage('LoginParent'); ?>
:
	<font color=green><b><?php echo $this->_tpl_vars['aData']['login_parent']; ?>
</b></font><?php endif; ?>
	<a href='/?action=message_compose&compose_to=<?php echo $this->_tpl_vars['aData']['login']; ?>
'
		><?php echo $this->_tpl_vars['oLanguage']->getMessage('Send message to customer'); ?>
</a>
	<br>
	<?php if ($this->_tpl_vars['aData']['password_temp']): ?>
	<b><font color=red><?php echo $this->_tpl_vars['oLanguage']->getMessage('Password'); ?>
:</b> <?php echo $this->_tpl_vars['aData']['password_temp']; ?>
</font><br>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['aData']['customer_name']): ?>
		<?php $this->assign('sCustomerName', $this->_tpl_vars['aData']['customer_name']); ?>
	<?php else: ?>
		<?php $this->assign('sCustomerName', $this->_tpl_vars['aData']['name']); ?>
	<?php endif; ?>
	<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Group'); ?>
:</b> <?php echo $this->_tpl_vars['aData']['customer_group_name']; ?>
<br>
		<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Email'); ?>
:</b> <?php echo $this->_tpl_vars['aData']['email']; ?>
<br>
		<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('City'); ?>
:</b> <font color=blue><?php echo $this->_tpl_vars['aData']['city']; ?>
 / <?php echo $this->_tpl_vars['aData']['delivery_type_name']; ?>
</font><br>
	<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('FLName Delivery'); ?>
:</b> <?php echo $this->_tpl_vars['sCustomerName']; ?>
<br>
	<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:</b> <?php echo $this->_tpl_vars['aData']['address']; ?>
<br>
	<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:</b> <?php echo $this->_tpl_vars['aData']['phone']; ?>
 <?php echo $this->_tpl_vars['aData']['phone2']; ?>
 <?php echo $this->_tpl_vars['aData']['phone3']; ?>
<br>
	<b>	<br>
</div>
</span>