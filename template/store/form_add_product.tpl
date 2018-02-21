<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<td width=50%><b>{$oLanguage->getDMessage('Pref')}</b>:{$sZir}</td>
		<td>{html_options name=data[pref] options=$aPref selected=$aData.pref}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getDMessage('code')}</b>:{$sZir}</td>
		<td><input type=text name=data[code]
			value="{$aData.code|escape}"></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getDMessage('name')}</b>:{$sZir}</td>
		<td><input type=text name=data[name]
			value="{$aData.name|escape}"></td>
	</tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}"> 