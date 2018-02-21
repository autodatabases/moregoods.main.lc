<td>{$aRow.id}</td>
<td>{$aRow.id_price_group}</td>
<td>{$aRow.id_provider}</td>
<td>{$aRow.code}</td>
<td>{$aRow.price}</td>
<td>{$aRow.part_rus}</td>
<td>{$aRow.pref}</td>
<td>{$aRow.cat}</td>
<td>{$aRow.post_date}</td>
<td>{$aRow.term}</td>
<td>{$aRow.stock}</td>
<td>{$aRow.number_min}</td>

<td nowrap>
{*include file='addon/mpanel/base_row_action.tpl' sBaseAction=$sBaseAction*}
<A href="?action={$sBaseAction}_delete&id={$aRow.id}&return={$sReturn|escape:"url"}" onclick="if (confirm_delete_glg())
xajax_process_browse_url(this.href);  return false;">
<IMG border=0 class=action_image src="/libp/mpanel/images/small/del.png"
		hspace=3 align=absmiddle>{$oLanguage->getDMessage('Delete')}</A>
</nobr>
</td>