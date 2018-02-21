<td class="cell-price"><nobr><a href="/?action=manager_customer_edit&id_user={$aRow.id}&return={$sReturn|escape:"url"}">{$aRow.id}</a>
{*<td class="cell-price">{$aRow.id} </td>*}
<td class="cell-name">{$oLanguage->AddOldParser('customer',$aRow.id_user)}</td>
<td class="cell-name">{$aRow.name}
{if $aRow.phone}{$aRow.phone}{/if}
</td>
<td class="cell-name">{$aRow.group_name}&nbsp;</td>
<td class="cell-name"><b>{$aRow.email}</b> <br> {$aRow.post_date}</td>
<td class="cell-name" style="white-space:nowrap;">
{*<a href="/?action=buh_changeling&search[id_buh]=361&search[id_subconto1]={$aRow.id}' target=_blank
	>{$oLanguage->GetMessage("Balance")}</a>
<a href="/?action=manager_customer_edit&id={$aRow.id}&return={$sReturn|escape:"url"}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle /> {$oLanguage->getMessage("CEdit")}</a>*}
</td>
