<td class="cell-price"> 
<div style="width:400px;overflow:auto;">
{include file='message/is_starred.tpl' aData=$aRow}

<a href="/?action=message_preview&id={$aRow.id}{if $bDraft}&draft=1{/if}"
	{if $aRow.is_read}class='normal'{/if}>{if $aRow.subject}{$aRow.subject}{else}{$oLanguage->GetMessage('(no subject)')}{/if}
	</a>
</div>
</td>
<td class="cell-name">
	{if $aRow.id_customer_from && $aAuthUser.type_=='manager'}
		{$oLanguage->AddOldParser('customer',$aRow.id_customer_from)}
	{else}{$aRow.from}{/if}
</td>
<td class="cell-name">
	{if $aRow.id_customer_to && $aAuthUser.type_=='manager'}
		{$oLanguage->AddOldParser('customer',$aRow.id_customer_to)}
	{else}{$aRow.to}{/if}
</td>
<td class="cell-name">{$oLanguage->getDateTime($aRow.timestamp)}</td>
<td class="cell-name" nowrap>
<a href="/?action=message_preview&id={$aRow.id}{if $bDraft}&draft=1{/if}"
	{if $aRow.is_read}class='normal'{/if} ><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle
	/>{$oLanguage->getMessage("Preview")}</a>

{if $smarty.session.message.current_folder_id!=4}
<a href="/?action=message_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	{if $aRow.is_read}class='normal'{/if}><img src="/image/delete.png" border=0  width=16 align=absmiddle
	/>{$oLanguage->getMessage("To Archive")}</a>
{/if}
</td>
