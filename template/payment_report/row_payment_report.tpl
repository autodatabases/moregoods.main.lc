{foreach key=sKey item=item from=$oTable->aColumn}
<td>
{if ($sKey == 'price')}
    {$oCurrency->PrintPrice($aRow.$sKey)}
{else}
    {if $sKey=='action'}
	<a href="/?action=payment_report_edit&id={$aRow.id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Edit")}</a>

	<a href="/?action=payment_report_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
    {else}
	{$aRow.$sKey}
    {/if}
{/if}
</td>
{/foreach}