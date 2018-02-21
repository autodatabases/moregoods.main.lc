{foreach key=sKey item=item from=$oTable->aColumn}
<td class="cell-name">
    {if $sKey=='action'}
	<a href="/?action=payment_declaration_manager_edit&id={$aRow.pd_id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Edit")}</a>

	<a href="/?action=payment_declaration_manager_delete&id={$aRow.pd_id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
    {else}
    	{if $sKey=='user'}
			{$oLanguage->AddOldParser('customer',$aRow.id_user)}
    	{else}
			{$aRow.$sKey}
		{/if}
    {/if}
</td>
{/foreach}