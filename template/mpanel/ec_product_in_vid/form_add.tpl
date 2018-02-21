<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('prouct in vid')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('product')}:{$sZir}</td>
    {*<td>
   {html_options name=data[id_product] options=$aProductList selected=$aData.id_product}
  </td>*}
     <td>
   <input name=data[id_product] value="{$aData.id_product|escape}">
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('vid')}:{$sZir}</td>
    <td>
   {html_options name=data[id_vid] options=$aVidList selected=$aData.id_vid}
  </td>
</tr>


{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>