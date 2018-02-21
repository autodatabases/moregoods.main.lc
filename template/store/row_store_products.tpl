<td>{$aRow.id}</td>
<td>{$aRow.cat}</td>
<td>{$aRow.code}</td>
<td>{$aRow.name}</td>
<td>{$aRow.item_code}</td>
<td nowrap>
<a href="/?action=store_products_edit&id={$aRow.id}" >
<img class="action_image" border="0" src="/libp/mpanel/images/small/edit.png" hspace="3" align="absmiddle">{$oLanguage->GetMessage('edit')}</a>
</td>