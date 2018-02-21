{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td class="cell-name" nowrap>
	<a href="/?action=manager_cat_add&id={$aRow.id}&return={$sReturn|escape:"url"}"
		><img src="/image/edit.png" border=0 width=16 align=absmiddle alt="{$oLanguage->getMessage("Edit")}" 
		  title="{$oLanguage->getMessage("Edit")}" />{$oLanguage->getMessage("Edit")}</a>
	<a href="/?action=manager_cat_pref&search[pref]={$aRow.pref}&return={$sReturn|escape:"url"}"
		><img src="/image/viewmagfit.png" border=0 width=16 align=absmiddle alt="{$oLanguage->getMessage("View pref")}" 
		  title="{$oLanguage->getMessage("View pref")}" />{$oLanguage->getMessage("View pref")}</a>
</td>
{elseif $sKey=='is_main' || $sKey=='is_brand'}
	<td class="cell-name">{if $aRow.$sKey}
		<b style="color:green">{$oLanguage->getMessage("Enable")}</b>
	{else}
		<b style="color:red">{$oLanguage->getMessage("Disable")}</b>
	{/if}</td>
{elseif $sKey=='visible'}
	<td class="cell-name">{if $aRow.$sKey}
		<b style="color:green">{$oLanguage->getMessage("visible")}</b>
	{else}
		<b style="color:red">{$oLanguage->getMessage("invisible")}</b>
	{/if}</td>
{else}<td class="cell-name">{$aRow.$sKey}</td>
{/if}
{/foreach}