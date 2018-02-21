<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
<tr>
 <th>
 {$oLanguage->getDMessage('Context hint')}
 </th>
</tr>
<tr><td>

<table cellspacing=2 cellpadding=1>
<tr>
   <td width=50%>{$oLanguage->getDMessage('Key')}:{$sZir}</td>
   <td><input type=text name=data[key_] value="{$aData.key_|escape}"></td>
</tr>
<tr>
	<td width="100%">{$oLanguage->getDMessage('Content')}:</td>
	<td>{$oAdmin->getCKEditor('data[content]',$aData.content)}</td>
</tr>
{include file='addon/mpanel/form_visible.tpl' aData=$aData}
</table>

</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}

</FORM>