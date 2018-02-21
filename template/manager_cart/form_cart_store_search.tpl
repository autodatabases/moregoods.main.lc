<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("User Account Amount")}:</b></td>
		<td><select name=search[amount]>
		<option value=''>{$oLanguage->getMessage("All")}</option>
		<option value='1' {if $smarty.request.search.amount=='1'}selected{/if} >{$oLanguage->getMessage("Positive")}</option>
		<option value='-1' {if $smarty.request.search.amount=='-1'}selected{/if}>{$oLanguage->getMessage("Negative")}</option>
		</select>

		<td><b>{$oLanguage->getMessage("Partner Region")}:</b></td>
		<td>
	<select name=search[id_partner_region]>
   		<option value=0>{$oLanguage->getMessage("Other region")}</option>
		{foreach from=$aPartnerRegion item=aItem}
		<option value={$aItem.id}
			{if $aItem.id == $smarty.request.search.id_partner_region} selected {/if}
				> {$aItem.name}</option>
		{/foreach}
	</select>
		</td>

	</tr>

	<tr>
		<td><b>{$oLanguage->getMessage("User Manager")}:</b></td>
		<td>{html_options name=search[id_user_manager] options=$aUserManager selected=$smarty.request.search.id_user_manager}</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

</table>