<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('discount')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Region')}:{$sZir}</td>
    <td>
   {html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('user')}:{$sZir}</td>
    <td>
   {html_options name=data[id_user] options=$aUserList selected=$aData.id_user}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('vt')}:{$sZir}</td>
    <td>
   {html_options name=data[id_vt] options=$aVtList selected=$aData.id_vt}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('product')}:{$sZir}</td>
    <td>
   {html_options name=data[id_product] options=$aProductList selected=$aData.id_product}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('condition_h')}:{$sZir}</td>
    <td>
   {html_options name=data[id_condition_h] options=$aConditionHList selected=$aData.id_condition_h}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('condition_d')}:{$sZir}</td>
    <td>
   {html_options name=data[id_condition_d] options=$aConditionDList selected=$aData.id_condition_d}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('type_discount')}:{$sZir}</td>
    <td>
   {html_options name=data[type_discount] options=$aTypeDiscountList selected=$aData.type_discount}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('discount')}:{$sZir}</td>
   <td><input type=text name=data[discount] value="{$aData.discount|escape}"></td>
</tr>


{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>