<td>{$aRow.id}</td>
<td>{$aRow.customer_group_name}</td>
<td>{$aRow.ct_name}</td>
<td>{include file='addon/mpanel/visible.tpl' aRow=$aRow}</td>
<td>{include file='addon/mpanel/base_row_edit.tpl' sBaseAction=$sBaseAction not_delete=1}</td>