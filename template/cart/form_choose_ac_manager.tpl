
			<tr>
				<td><b>{$oLanguage->getMessage("City")}:</b>{if $smarty.session.current_cart.price_delivery>0}{$sZir}{/if}</td>
				<td><input type=text id="city" name=data[city] readonly value='{$aDataAlready.city}' maxlength=50 style="width: 150%;"></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("Zip")}:</b></td>
				<td><input type=text name=data[zip] readonly value='{$aDataAlready.zip|escape}' maxlength=50 style="width: 150%;"></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("Address")}:{if $smarty.session.current_cart.price_delivery>0}{$sZir}{/if}</b></td>
				<td><textarea name=data[address] readonly style="width: 150%;">{$aDataAlready.address|escape}</textarea></td>
			</tr>
			<tr>
				<td><b>{$oLanguage->getMessage("Phone")}: </b></td>
				<td><input type=text name=data[phone] readonly value='{$aDataAlready.phone|escape}' maxlength=50 class='phone' style="width: 150%;"></td>
			</tr>
		{*	<tr>
				<td><b>{$oLanguage->getMessage("Remarks")}:</b></td>
				<td><textarea name=data[remark] style="width: 150%;">{$aDataAlready.remark|escape}</textarea></td>
			</tr>
		*}