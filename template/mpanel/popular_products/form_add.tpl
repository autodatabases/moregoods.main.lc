<FORM id='main_form' action='javascript:void(null);'onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Popular Products')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('id_products')}:{$sZir}</td>
   <td><input type=text name=data[id_products] value="{$aData.id_products|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('old price')}:</td>
   <td><input type=text name=data[old_price] value="{$aData.old_price|escape}"></td>
</tr>
<tr>
	<td width=50%>{$oLanguage->getDMessage('bage')}:{$sZir}</td>
	<td>{html_options name=data[bage] options=$aBage selected=$aData.bage}</td>
</tr>
{include file='addon/mpanel/form_image.tpl' aData=$aData bNotHidden=1}
{include file='addon/mpanel/form_visible.tpl' aData=$aData}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>