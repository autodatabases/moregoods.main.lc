<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Discount')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Amount')}:{$sZir}</td>
   <td><input type=text name=data[amount] value="{$aData.amount|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Discount')}:{$sZir}</td>
   <td><input type=text name=data[discount] value="{$aData.discount|escape}"></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>