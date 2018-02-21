<table>
	<tr>
	   	<td><b>{$oLanguage->getMessage("Provider")}:{$sZir}</b></td>
   		<td><select id=id_user_provider name=data[id_user_provider] style="width: 270px;">
			{html_options options=$aUserProvider selected=$aData.id_user_provider}
			</select>
		</td>
	</tr>
	<tr>
	   	<td><b>{$oLanguage->getMessage("Price profile")}:</b></td>
   		<td><select id=id_price_profile name=data[id_price_profile] style="width: 270px;">
			{html_options options=$aPriceProfile selected=$aData.id_price_profile}
			</select>
		</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("File Name")}:</b></td>
		<td><input type=text name=data[file_name] value='{$aData.file_name}' maxlength=50 style='width:266px' readonly></td>
	</tr>
	<td width=50%><b>{$oLanguage->getMessage("Processe")}:</b></td>
	<td><input type="hidden" name=data[is_processed] value="0">
   	<input type=checkbox name=data[is_processed] value='1' style="width:22px;" {if $aData.is_processed}checked{/if}></td>
	</tr>
</table>