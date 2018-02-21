<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Constant')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
  <tr>
   <td width=50%>{$oLanguage->getDMessage('Key')}:{$sZir}</td>
   <td><input type=text name=data[key_] value="{$aData.key_|escape}"></td>
  </tr>
  <tr>
   <td>{$oLanguage->getDMessage('Value')}:{$sZir}</td>
   <td><input type=text name=data[value] value="{$aData.value|escape}"></td>
  </tr>
  <tr>
	<td width="100%">{$oLanguage->getDMessage('Description')}: {$sZir}</td>
	<td><textarea name=data[description]>{$aData.description}</textarea></td>
  </tr>
  </table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>