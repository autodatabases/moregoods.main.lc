<!--div class="form_title_div">
<span class="red_box">
{$oLanguage->GetMessage('login with other site')}
</span>
</div>
<div style="margin-left: 5px;">
{literal}<script src="http://ulogin.ru/js/ulogin.js"></script>{/literal}
<div id="uLogin" x-ulogin-params="display=small;fields={$oLanguage->GetConstant('ulogin:fields','first_name,last_name,email,nickname')};providers={$oLanguage->GetConstant('ulogin:providers','vkontakte,facebook,twitter,google')};hidden=other;redirect_uri={$sUloginURI}">
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
	{$oLanguage->getMessage("Log In")}
	</span>
	</div>
	{$oLanguage->getText("Already registered? Use this form to log in")}
	{if $smarty.request.error_login}
	<div><span style="color:red;">{$oLanguage->GetMessage("Authorization error. Please check CapsLock, Language and try again")}</span></div>
	{/if}
	{if $smarty.request.login_error}
	<div><span style="color:red;">{$oLanguage->GetMessage("Authorization type error. Please, relogin.")}</span></div>
	{/if}
	<table>
<tr>
	<td><b>{$oLanguage->getMessage("Login")}:</b></td>
	<td> <input maxlength="50" size="18" type="text" name="login" value="" style="width: 230px;"/> </td>
</tr>
<tr>
	<td><b>{$oLanguage->getMessage("Password")}:</b></td>
	<td> <input maxlength="50" size="18" name="password" type="password" style="width: 230px;" /> </td>
</tr>

<tr>
	<td colspan=2>
	<input value="{$oLanguage->getMessage("Enter")}" name="auth" class='btn' type="submit">
	<input name="action" value="user_do_login" type="hidden">
	<!--input name="redirect_action" value="customer_new_account" type="hidden"-->
	</td>
</tr>

<tr>
	<td colspan=2><br>
		<a href="/?action=user_new_account">{$oLanguage->getMessage("Register")}</a> <br>
		<a href="/?action=user_restore_password">{$oLanguage->getMessage("Restore password?")}</a>
	</td>
</tr>
</table>

	</td>
	<td class="for_mobile"  style="width:50%;text-align:top;">

	<div class="form_title_div">
	<span class="red_box">
	{$oLanguage->getMessage("Register")}
	</span>
	</div>

	

<br>
<br>
	<input type=button class='btn'  value="{$oLanguage->getMessage("Register")}" onClick="location.href='/?action=user_new_account'">
	</td>
</tr>
</table>
</form>