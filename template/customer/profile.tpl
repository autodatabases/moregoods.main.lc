<table class="gm-block-order-filter2 no-mobile" 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 54px;
    position: relative;">
	<tr>
		<td>{$oLanguage->GetMessage("Your login")}:
		{if $bLoginChange}{$oLanguage->getContextHint("customer_account_login_change")}{/if}</td>
		<td style="border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;">{$aUser.login}&nbsp;&nbsp;
		{* {if $bLoginChange}<a class="gm-link-dashed" href='/?action=user_change_login'>{$oLanguage->GetMessage("Change Login")}{/if} *}
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Your email")}:{$sZir}</td>
		<td style="padding: 10px 0;"><input type=text name=data[email] value='{$aUser.email}' maxlength=50 style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Password")}:</td>
		<td style="padding: 10px 0px 10px 0px;">******
		{if ! $bReadOnly}&nbsp;&nbsp;<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 20px 10px 20px; border-radius: 5px;background-color: white;" 
		href='/?action=user_change_password'>{$oLanguage->GetMessage("Change Password")}{/if}</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Your manager")}:</td>
		<td style="padding: 10px 0px 10px 0px;"> {$aAuthUser.manager_login}
&nbsp;
	<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 44px 10px 44px; border-radius: 5px;background-color: white;" 
	href='/?action=message_compose&compose_to={$aAuthUser.manager_login}'
		>{$oLanguage->getMessage("Send message to manager")}</a>

		</td>
	</tr>
	
	{*
	<tr>
		<td>{$oLanguage->GetMessage("Your messages")}:</td>
		<td><a class="gm-link-dashed" href='/?action=message'>{$oLanguage->getMessage("Look for messages")}</a>
		{if $iUnreadMessages>0}
			({$oLanguage->GetMessage('You have')} {$iUnreadMessages}
			{$oLanguage->GetMessage('unread messages')})
		{/if}
		</td>
	</tr>
	*}
{*
	<tr>
		<td>{$oLanguage->GetMessage("Discount Static")}:
			{$oLanguage->getContextHint("customer_discount_static")}</td>
		<td>{$aUser.discount_static} %</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Discount Dynamic")}:
			{$oLanguage->getContextHint("customer_discount_dynamic")}</td>
		<td>{$aUser.discount_dynamic} %</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Group Discount")}:
			{$oLanguage->getContextHint("customer_group_discount")}</td>
		<td>{$aUser.group_discount} %</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Показывать цены без скидки")}:</td>
		<td><input name=data[disc_disabled]  type='checkbox' {if $aUser.disc_disabled}checked{/if}/></td>
	</tr>
	*}



	<tr>
		<td colspan=2><i>{$oLanguage->GetMessage("Delivery info")}</i><hr /></td>
	</tr>
    <script type="text/javascript" src="/js/user.js?2"></script>
	<tr>
		<td><nobr>{$oLanguage->GetMessage("FLName")}:{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[name] value='{$aUser.name|stripslashes}' style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>

	<tr>
		<td><nobr>{$oLanguage->GetMessage("City")}:{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[city] value='{$aUser.city|stripslashes}' style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
  	<tr>
		<td><nobr>{$oLanguage->GetMessage("Address")}:{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[address] value='{$aUser.address|stripslashes}' style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
	<tr>
		<td><nobr>{$oLanguage->GetMessage("Phone")}:{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[phone] value='{$aUser.phone|stripslashes}' style='width:100%' id='user_phone' placeholder="(___)___ __ __"
		{if $bReadOnly}readonly{/if}></td>
	</tr>
{*	
	<tr>
		<td>{$oLanguage->getMessage("Store num rating")}:</td>
		<td>
		<select onchange="
{strip}
xajax_process_browse_url('/?action=customer_change_rating
&id_user={$aRow.id_user}&num_rating='+this.value); return false;
{/strip}"
			style='width:100%' class="js-uniform">
			{html_options options=$aRatingAssoc selected=$aAuthUser.num_rating}

		</select>
		</td>
	</tr>
*}	
	<tr>
		<td valign=top>{$oLanguage->GetMessage("CustomerRemarks")}:</td>
		<td><textarea name=data[remark] style='width:100%' {if $bReadOnly}disabled{/if}>{$aUser.remark|stripslashes}</textarea></td>
	</tr>
	
	
</table>