<td class="cell-name" style="padding-left: 10px;width: 36px;font-size: 14px;float: none;">{$aRow.id}</td>
<td class="cell-name" style="width:20%;float: none;;">{$oLanguage->AddOldParser('customer',$aRow.id_user)}</td>
<td class="cell-name" style="width:20%;float: none;">{$aRow.name}
{if $aRow.phone}{$aRow.phone}{/if}
</td>
<td class="cell-name" style="width:10%;float: none;">{$aRow.group_name}</td>
<td class="cell-name" style="width:20%;float: none;"><b>{$aRow.email}</b> <br> {$aRow.post_date}</td>
<td class="cell-name" style="width:20%;float: none;">
<nobr>
{if $aRow.is_fill==0}
	<a style="font-size: 12px;" href="/?action=manager_customer_list_fill_add&id_list={$aRow.id_list}&id={$aRow.id}
	{if $smarty.request.search.id_user}&search[id_user]={$smarty.request.search.id_user}{/if}
	{if $smarty.request.search.login}&search[login]={$smarty.request.search.login}{/if}
	{if $smarty.request.search.name}&search[name]={$smarty.request.search.name}{/if}
	{if $smarty.request.search.phone}&search[phone]={$smarty.request.phone}{/if}
	{if $smarty.request.search.group_id}&search[group_id]={$smarty.request.search.group_id}{/if}
	{if $smarty.request.search.inlist}&search[inlist]={$smarty.request.search.inlist}{/if}
	">
	<img src="/image/apply.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Add")}</a>
{else}
	<a style="font-size: 12px;"href="/?action=manager_customer_list_fill_delete&id_list={$aRow.id_list}&id={$aRow.id}
	{if $smarty.request.search.id_user}&search[id_user]={$smarty.request.search.id_user}{/if}
	{if $smarty.request.search.login}&search[login]={$smarty.request.search.login}{/if}
	{if $smarty.request.search.name}&search[name]={$smarty.request.search.name}{/if}
	{if $smarty.request.search.phone}&search[phone]={$smarty.request.phone}{/if}
	{if $smarty.request.search.group_id}&search[group_id]={$smarty.request.search.group_id}{/if}
	{if $smarty.request.search.inlist}&search[inlist]={$smarty.request.search.inlist}{/if}
	"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;">
	<img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
{/if}
</nobr>
</td>
