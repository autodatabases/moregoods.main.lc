<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Currency')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Code')}:{$sZir}</td>
   <td><input type=text name=data[code] value="{$aData.code|escape}"></td>
</tr>

<tr>
   <td width=50%>{$oLanguage->getDMessage('Name')}:{$sZir}</td>
   <td><input type=text name=data[name] value="{$aData.name|escape}"></td>
</tr>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Symbol')}:</td>
   <td><input type=text name=data[symbol] value="{$aData.symbol|escape}"></td>
</tr>

{include file='addon/mpanel/form_image.tpl' aData=$aData}

<tr>
   <td width=50%>{$oLanguage->getDMessage('Value')}:{$sZir}</td>
   <td><input type=text name=data[value] value="{$aData.value|escape}"></td>
</tr>

<tr>
   <td>{$oLanguage->getDMessage('Price round')}:</td>
   <td><input type=text name=data[price_round] value="{$aData.price_round|escape}"></td>
</tr>
<tr>
   <td>{$oLanguage->getDMessage('Price ceil')}:</td>
   <td><input type=text name=data[price_ceil] value="{$aData.price_ceil|escape}"></td>
</tr>

{include file='addon/mpanel/form_visible.tpl' aData=$aData}

<tr>
   <td>{$oLanguage->getDMessage('Num')}:</td>
   <td><input type=text name=data[num] value="{$aData.num|escape}"></td>
</tr>

<tr>
   <td>{$oLanguage->getDMessage('Is Public')}:</td>
   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_public' bChecked=$aData.is_public}</td>
</tr>

</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>