<?php /* Smarty version 2.6.18, created on 2018-02-19 20:35:29
         compiled from cart/order_by_phone_2.tpl */ ?>
 <?php if (! ( $this->_tpl_vars['aAuthUser']['id'] && ! ( $this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aAuthUser']['login']) ) )): ?>
<table class='auth-form  no-mobile no-tablet respons' 
style=" background-color: white;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 20px;
    position: relative;
    left: 10px;">
	<tr >
	<td >
	        <div class="register-advantages" style="width:320px">
								<a class="gm-button" style="margin: 18px 0px 0px 20px;" href="/pages/user_new_account"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('register'); ?>
</a>
			</div>

	</td>
	</tr>
	</table>

<table class='auth-form respons' 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 -20px 20px 0;
    border: 1px solid #5fb7c1;
    padding: 10px 20px 20px 20px;
    position: relative;
    left: 20px;">
	
	
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td valign=center style="font-size: 16px;font-weight: 800;">+38 
		<input type="text" name=data[order_by_phone] placeholder="(___)___ __ __" style="width: 200px;" value="<?php if ($this->_tpl_vars['aAuthUser']['phone']): ?><?php echo $this->_tpl_vars['aAuthUser']['phone']; ?>
<?php else: ?><?php echo $_REQUEST['user_phone']; ?>
<?php endif; ?>" id="user_phone" class="phone fast_order_phone"/>
		</td>
	</tr>
	<tr>
		<td><nobr><?php echo $this->_tpl_vars['oLanguage']->getMessage('Your name'); ?>
:</td>
		<td valign=center>
		<input type=text name=data[name] value='<?php if ($this->_tpl_vars['aData']['name']): ?><?php echo $this->_tpl_vars['aData']['name']; ?>
<?php else: ?><?php echo $_REQUEST['user_name']; ?>
<?php endif; ?>' style='width:240px' id="user_name"></td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('email'); ?>
:</td>
		<td><input type=email name=data[email] value='<?php echo $_REQUEST['user_email']; ?>
' maxlength=50 style='width:240px' id="user_email"></td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Comment'); ?>
:</td>
		<td><textarea name=data[remark] style='width:240px' id="user_comment"><?php if ($this->_tpl_vars['aData']['remark']): ?><?php echo $this->_tpl_vars['aData']['remark']; ?>
<?php else: ?><?php echo $_REQUEST['user_comment']; ?>
<?php endif; ?></textarea></td>
	</tr>
	<tr>
		<td colspan=2>
                    <div class="capcha">
<?php echo $this->_tpl_vars['oLanguage']->getMessage('Capcha field'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>

                        <div class="formula">
                            <?php echo $this->_tpl_vars['sCapcha']; ?>

                        </div>
                    </div>
		</td>				
	</tr>

	<tr>
	<td colspan=2 style="padding: 0 0 0 16px;">
                    <input class="gm-button" type="submit" value="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('Order by phone'); ?>
"> 	</td>
	</tr>
	
	
	</table>



<?php endif; ?>