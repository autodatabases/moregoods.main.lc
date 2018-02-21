<?php /* Smarty version 2.6.18, created on 2018-02-20 12:15:57
         compiled from user/login.tpl */ ?>
<!--div class="form_title_div">
<span class="red_box">
<?php echo $this->_tpl_vars['oLanguage']->GetMessage('login with other site'); ?>

</span>
</div>
<div style="margin-left: 5px;">
<?php echo '<script src="http://ulogin.ru/js/ulogin.js"></script>'; ?>

<div id="uLogin" x-ulogin-params="display=small;fields=<?php echo $this->_tpl_vars['oLanguage']->GetConstant('ulogin:fields','first_name,last_name,email,nickname'); ?>
;providers=<?php echo $this->_tpl_vars['oLanguage']->GetConstant('ulogin:providers','vkontakte,facebook,twitter,google'); ?>
;hidden=other;redirect_uri=<?php echo $this->_tpl_vars['sUloginURI']; ?>
">
</div>
</div>
<div class="reg_or_line">
<img src="/image/design/or_line.gif"></img>
</div-->

<form method=post>
<table style="width:100%">
<tr>
	<td class="for_mobile" style="width:50%;text-align:top;">

	<div class="form_title_div">
	<span class="red_box">
	<?php echo $this->_tpl_vars['oLanguage']->getMessage('Log In'); ?>

	</span>
	</div>
	<?php echo $this->_tpl_vars['oLanguage']->getText("Already registered? Use this form to log in"); ?>

	<?php if ($_REQUEST['error_login']): ?>
	<div><span style="color:red;"><?php echo $this->_tpl_vars['oLanguage']->GetMessage("Authorization error. Please check CapsLock, Language and try again"); ?>
</span></div>
	<?php endif; ?>
	<?php if ($_REQUEST['login_error']): ?>
	<div><span style="color:red;"><?php echo $this->_tpl_vars['oLanguage']->GetMessage("Authorization type error. Please, relogin."); ?>
</span></div>
	<?php endif; ?>
	<table>
<tr>
	<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</b></td>
	<td> <input maxlength="50" size="18" type="text" name="login" value="" style="width: 230px;"/> </td>
</tr>
<tr>
	<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Password'); ?>
:</b></td>
	<td> <input maxlength="50" size="18" name="password" type="password" style="width: 230px;" /> </td>
</tr>

<tr>
	<td colspan=2>
	<input value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Enter'); ?>
" name="auth" class='btn' type="submit">
	<input name="action" value="user_do_login" type="hidden">
	<!--input name="redirect_action" value="customer_new_account" type="hidden"-->
	</td>
</tr>

<tr>
	<td colspan=2><br>
		<a href="/?action=user_new_account"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Register'); ?>
</a> <br>
		<a href="/?action=user_restore_password"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Restore password?"); ?>
</a>
	</td>
</tr>
</table>

	</td>
	<td class="for_mobile"  style="width:50%;text-align:top;">

	<div class="form_title_div">
	<span class="red_box">
	<?php echo $this->_tpl_vars['oLanguage']->getMessage('Register'); ?>

	</span>
	</div>

	

<br>
<br>
	<input type=button class='btn'  value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Register'); ?>
" onClick="location.href='/?action=user_new_account'">
	</td>
</tr>
</table>
</form>