<table class="add_public_provider">

	<tr>
		<td class="form-label"><nobr><b>{$oLanguage->getMessage("Name")}:</b>{$sZir}</td>
		<td class="form-input" valign=center width=280>
		<input type=text name=data[name] value='{$smarty.request.name}' style='width:230px' /></td>
	</tr>
		
	<tr>
		<td class="form-label" ><nobr><b>{$oLanguage->getMessage("City")}:</b>{$sZir}</td>
		<td class="form-input" valign=center width=280>
		<input type=text name=data[city] value='{$smarty.request.city}' style='width:230px' /></td>
	</tr>

	<tr>
		<td class="form-label"><nobr><b>{$oLanguage->getMessage("Email")}:</b>{$sZir}</td>
		<td class="form-input" valign=center width=280>
		<input type=text name=data[email] value='{$smarty.request.email}' style='width:230px' /></td>
	</tr>
	
	<tr>
		<td><nobr><b>{$oLanguage->getMessage("Phone")}:</b>{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[phone] value='{if $aUser.name}{$aUser.phone}{else}{$smarty.request.data.phone}{/if}' style='width:270px'></td>
	</tr>
	
	<tr>
   		<td><b>{$oLanguage->getMessage("Add price")}:</b></td>
   		<td><input type=file name=price style='width:270px'></td>
  	</tr>


	
</table>