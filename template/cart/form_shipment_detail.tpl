<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("FLName")}: {$sZir}</b></td>
   		<td><input type=text name=data[name] value='{$aUser.name|escape}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("City")}:</b>{if $smarty.session.current_cart.price_delivery>0}{$sZir}{/if}</td>
		<td><input type=text name=data[city] value='{$aUser.city|escape}' maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Zip")}:</b></td>
		<td><input type=text name=data[zip] value='{$aUser.zip|escape}' maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Address")}:{if $smarty.session.current_cart.price_delivery>0}{$sZir}{/if}</b></td>
		<td><textarea name=data[address] style='width:270px'>{$aUser.address|escape}</textarea></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Phone")}: {$sZir}</b></td>
		<td><input type=text name=data[phone] value='{$aUser.phone|escape}' maxlength=50 style='width:270px' class='phone'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Remarks")}:</b></td>
		<td><textarea name=data[remark] style='width:270px'>{$aUser.remark|escape}</textarea></td>
	</tr>
</table>