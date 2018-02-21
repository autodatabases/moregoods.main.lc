<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)" >
<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('seria_p')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('product')}:{$sZir}</td>
    <td>
   {html_options name=data[id_product] options=$aProductList selected=$aData.id_product}
  </td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('seria_p')}:{$sZir}</td>
    <td>
   {html_options name=data[id_seria_p] options=$aSeriaPList selected=$aData.id_seria_p}
  </td>
</tr>


{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>