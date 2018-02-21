<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Customer")}:</b>{$sZir}</td>
   		<td>
   		<select name=id_user style='width:270px'>
		{foreach from=$aCustomer item=aRow}
			<option value='{$aRow.id}' {if $aRow.id==$smarty.request.id_user}selected{/if}>{$aRow.login} - {$aRow.name}</option>
		{/foreach}
			</select>
		</td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Code")}:</b>{$sZir}</td>
   		<td><input type=text name=code value='{$aData.code}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Number")}:</b>{$sZir}</td>
   		<td><input type=text name=number value='{$aData.number}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Price")} ($):</b>{$sZir}</td>
   		<td><input type=text name=price value='{$aData.price}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Name")}:</b>{$sZir}</td>
   		<td><input type=text name=name value='{$aData.name}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Term")}:</b>{$sZir}</td>
   		<td><input type=text name=term value='{$aData.term}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Weight")}:</b>{$sZir}</td>
   		<td><input type=text name=weight value='{$aData.weight}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Item Code")}:</b>{$sZir}</td>
   		<td><input type=text name=item_code value='{$aData.item_code}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Cat name")}:</b></td>
   		<td><input type=text name=cat_name value='{$aData.cat_name}' maxlength=50 style='width:270px'></td>
  	</tr>

{if $aAuthUser.is_super_manager || $aAuthUser.is_sub_manager}
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Provider name")}:</b></td>
   		<td>{$aData.provider_name}</td>
  	</tr>
{/if}
</table>