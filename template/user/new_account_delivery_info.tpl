{if $smarty.request.action=='user_new_account'}
<div class="form-element">
					<div class="element-name">{$oLanguage->getDMessage('Region')}:{$sZir}</div>
    {if $aUser.id_region}
        {assign var=iIdRegion value=$aUser.id_region}
    {else}
        {assign var=iIdRegion value=$smarty.request.data.id_region}
    {/if}
   {html_options name=data[id_region] options=$aRegionList selected=$iIdRegion style='width: 92% !important;max-width: 400px;'}
</div>
{/if}
<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("FLName")}:{$sZir}</div>
	<input type=text name=data[name] value='{if $aUser.name}{$aUser.name}{else}{$smarty.request.data.name}{/if}' style='width:100%'>
</div>
<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("City")}:{$sZir}</div>
	<input type=text name=data[city] value='{if $aUser.name}{$aUser.city}{else}{$smarty.request.data.city}{/if}' style='width:100%'>
	</div>
<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Address")}:{$sZir}</div>
	<input type=text name=data[address] value='{if $aUser.name}{$aUser.address}{else}{$smarty.request.data.address}{/if}' style='width:100%'>
	</div>
{if $smarty.request.action!='user_new_account' && $smarty.request.action!='cart_onepage_order'}
<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Phone")}:{$sZir}</div>
	<input type=text name=data[phone] value='{if $aUser.phone}{$aUser.phone}{else}{$smarty.request.data.phone}{/if}' style='width:100%' class='phone'>
	</div>
{/if}
<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Remarks")}:</div>
					<textarea name=data[remark] style='width:100%'>{if $aUser.name}{$aUser.remark}{else}{$smarty.request.data.remark}{/if}</textarea>
	</div>