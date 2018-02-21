<?php /* Smarty version 2.6.18, created on 2017-05-16 19:40:22
         compiled from manager/form_package.tpl */ ?>
<table class="gm-block-order-filter2 no-mobile" 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 20px;
    position: relative;">
	<tr>
   		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</td>
   		<td>
   		<?php if ($this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aData']['login'])): ?>
      	     <input type=text name=data[change_login] value='m<?php echo $this->_tpl_vars['aData']['login']; ?>
' maxlength=50 style='width:270px' readonly>
      	     <input type="hidden" name=data[login] value='<?php echo $this->_tpl_vars['aData']['login']; ?>
' maxlength=50 style='width:270px' readonly>
      	<?php else: ?>
      	     <input type=text name=data[login] value='<?php echo $this->_tpl_vars['aData']['login']; ?>
' maxlength=50 style='width:270px' readonly>
      	<?php endif; ?>
   		</td>
  	</tr>	
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('email'); ?>
:</td>
		<td><input type=text name=data[email] value='<?php echo $this->_tpl_vars['aData']['email']; ?>
' maxlength=50 style='width:270px'></td>
	</tr>
	
		<tr>
	<td colspan=2><i><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delivery info'); ?>
</i><hr /></td>
	</tr>
	<tr>
	<td><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('FLName'); ?>
:</td>
	<td valign=center width=280>
	<input type=text name=data[name] value='<?php if ($this->_tpl_vars['aData']['name']): ?><?php echo $this->_tpl_vars['aData']['name']; ?>
<?php else: ?><?php echo $_REQUEST['data']['name']; ?>
<?php endif; ?>' style='width:270px'></td>
</tr>
<tr>
	<td><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('City'); ?>
:</td>
	<td valign=center width=280>
	<input type=text name=data[city] value='<?php if ($this->_tpl_vars['aData']['city']): ?><?php echo $this->_tpl_vars['aData']['city']; ?>
<?php else: ?><?php echo $_REQUEST['data']['city']; ?>
<?php endif; ?>' style='width:270px'></td>
</tr>
	<tr>
	<td><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Address'); ?>
:</td>
	<td valign=center width=280>
	<input type=text name=data[address] value='<?php if ($this->_tpl_vars['aData']['address']): ?><?php echo $this->_tpl_vars['aData']['address']; ?>
<?php else: ?><?php echo $_REQUEST['data']['address']; ?>
<?php endif; ?>' style='width:270px'></td>
</tr>
<tr>
	<td><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:</td>
	<td valign=center width=280>
	<input type=text name=data[phone] value='<?php if ($this->_tpl_vars['aData']['phone']): ?><?php echo $this->_tpl_vars['aData']['phone']; ?>
<?php else: ?><?php echo $_REQUEST['data']['phone']; ?>
<?php endif; ?>' style='width:270px'></td>
</tr>
<tr>
	<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Comment'); ?>
:</td> 
	<td><textarea name=data[remark] style='width:270px'><?php if ($this->_tpl_vars['aData']['remark']): ?><?php echo $this->_tpl_vars['aData']['remark']; ?>
<?php else: ?><?php echo $_REQUEST['data']['remark']; ?>
<?php endif; ?></textarea></td>
</tr>
<?php if ($this->_tpl_vars['aData']['is_order_by_phone_customer'] == 1): ?>
<tr>
	<td colspan=2>
	<b><?php echo $this->_tpl_vars['oLanguage']->getMessage('is_by_phone_customer'); ?>
</b>
	</td>
</tr>
<?php endif; ?>
			<?php if ($this->_tpl_vars['aData']['is_need_check']): ?>
		<tr>
			<td></td>
			<td>
				<span id="auto_<?php echo $this->_tpl_vars['aData']['id']; ?>
" onclick="set_checked_auto(this,<?php if (( $this->_tpl_vars['aData']['is_checked_auto'] )): ?>'0'<?php else: ?>'1'<?php endif; ?>)" 
				     onmouseout="$('#tip_auto_<?php echo $this->_tpl_vars['aData']['id']; ?>
').hide();" onmouseover="$('#tip_auto_<?php echo $this->_tpl_vars['aData']['id']; ?>
').show();">
				<?php if ($this->_tpl_vars['aData']['is_checked_auto'] == 0): ?>
					<a><img src="/image/design/not_sel_chk.png"></img></a>
				<?php else: ?>
					<a><img src="/image/design/sel_chk.png"></img></a>
				<?php endif; ?>
				<div align="left" style="width: 500px; display: none;" class="tip_div" id="tip_auto_<?php echo $this->_tpl_vars['aData']['id']; ?>
"><?php echo $this->_tpl_vars['sAutoInfo']; ?>
</div>
				</span>
			</td>	
		</tr>
	<?php endif; ?>
	</table>