<table class="gm-block-order-filter2" style="background-color: #f8f8f8;border-radius: 5px;margin: 0 0 20px 0;border: 1px solid #5fb7c1; padding: 20px 20px 20px 20px;position: relative;">
	<tr>
   		<td width=30%><b>{$oLanguage->getMessage("Name")}:{$sZir}</b></td>
   		<td><input type=text name=name value='{$aUser.name}' maxlength=50 style='width:100%'></td>
  	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage("Your email")}:</b>{$sZir}</td>
		<td style="padding: 10px 0;"><input type=text name=email value='{$aUser.email}' maxlength=50 style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage("Your login")}:</b></td>
		<td style="border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;">{$aUser.login}</td>
	<tr>
		<td><b>{$oLanguage->GetMessage("Password")}:{$sZir}</b></td>
		<td style="padding: 10px 0px 10px 0px;">******
		{if ! $bReadOnly}&nbsp;&nbsp;<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 20px 10px 20px; border-radius: 5px;background-color: white;" 
		href='/?action=user_change_password'>{$oLanguage->GetMessage("Change Password")}{/if}</td>
	</tr>
	{*<tr>
		<td><b>{$oLanguage->GetMessage("Language po default")}:</b></td>
		<td valign=center width=280>
				<span style="width: 283px; user-select: none;"></span>
				<select name=data[language] name="id_customer_partner" class="js-uniform" style="width: 280px; height: 40px">
				<option value="ua" {if $aUser.language=='ua'}selected{/if}>{$oLanguage->GetMessage("ukrainian")}</option>
				<option value="ru" {if $aUser.language=='ru'}selected{/if}>{$oLanguage->GetMessage("russian")}</option>
			</select>
		</td>
	</tr>*}
	
	<tr>
		<td><b>{$oLanguage->getMessage("Address")}:{$sZir}</b></td>
		<td><textarea name=address style='width:100%'>{$aUser.address}</textarea></td>
	</tr>

	<tr>
		<td><b>{$oLanguage->getMessage("Phone")}:{$sZir}</b></td>
		<td><input type=text name=phone value='{$aUser.phone}' maxlength=50 style='width:100%'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("CustomerRemarks")}:{$sZir}</b></td>
		<td><textarea name=remark style='width:100%'>{$aUser.remark}</textarea></td>
	</tr>
</table>