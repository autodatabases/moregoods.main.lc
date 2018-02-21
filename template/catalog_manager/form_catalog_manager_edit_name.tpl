<table width="99%">
<tr>
	<td><b>{$oLanguage->getMessage("Item_code")} :</b></td>
	<td><input type="text" readonly name=data[item_code] value='{$aData.item_code}'></td>
	</tr>
<tr>
	<td><b>{$oLanguage->getMessage("tecdoc_name")} :</b></td>
	<td>{$aPartInfo.name}</td>
	</tr>
<tr>
	<td><b>{$oLanguage->getMessage("Catalog name")} :</b></td>
	<td><input type=text name=data[name_rus] value='{$aData.name_rus|escape}' maxlength=250 style='width:250px'></td>
	</tr>
<tr>
	<td><b>{$oLanguage->getMessage("Information")} :</b></td>
	<td><textarea name=data[information] style='width:255px' rows="5">{$aData.information|escape}</textarea></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Hide tecdoc Image")}:</b></td>
	<td><input type="hidden" name=data[hide_tof_image] value="0">
   <input type=checkbox name=data[hide_tof_image] value='1' style="width:22px;" {if $aData.hide_tof_image}checked{/if}></td>
	</tr>
	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Price Group")}:{$sZir}</b></td>
   	<td nowrap><select id=id_price_group name=data[id_price_group] style="width:145px">
   	{html_options  options=$aPriceGroup2 selected=$aselectPrice}
	</select>
   	</td>
   </tr>
</table>
