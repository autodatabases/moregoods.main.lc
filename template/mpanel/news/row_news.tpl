<td>{$aRow.id}</td>
<td>{$aRow.short|truncate:50:""}</td>
<td>{include file='addon/mpanel/image.tpl' aRow=$aRow sWidth=30}</td>
<td>{$aRow.section}</td>
<td>{$aRow.full|strip_tags|truncate:80:""}</td>
<td>{if $aRow.post_date != ''}{$aRow.post_date|date_format:"%d-%m-%Y"}{/if}</td>
<td>{$aRow.customer_group_name}</td>
<td>{$aRow.region}</td>
<td>{include file='addon/mpanel/visible.tpl' aRow=$aRow}</td>
<td>{$aRow.num}</td>
<td nowrap>{include file='addon/mpanel/base_lang_select.tpl'}</td>
<td nowrap>{include file='addon/mpanel/base_row_action.tpl'
sBaseAction=$sBaseAction}</td>
