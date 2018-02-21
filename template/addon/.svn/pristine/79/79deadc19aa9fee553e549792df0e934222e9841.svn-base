<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>{$oLanguage->getDMessage('Change password')}</th>
	</tr>
	<tr>
		<td>


<table cellspacing=2 cellpadding=1>
	<tr>
   		<td>{$oLanguage->getDMessage('Password')}:{$sZir}</td>
   		<td><input type=password name=data[password] value='{$aData.password}'></td>
  	</tr>
  	<tr>
   		<td>{$oLanguage->getDMessage('Retype Password')}:{$sZir}</td>
   		<td><input type=password name=data[retype_password] value='{$aData.retype_password}'></td>
  	</tr>
</table>


	</td></tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">

{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}
<input type=hidden name=action value=admin_change_password_apply>
</FORM>