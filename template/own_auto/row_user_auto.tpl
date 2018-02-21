<td>{$aRow.id_make}</td>
<td>{$aRow.id_model}</td>
<td>{$aRow.month} {$aRow.year}</td>
<td><nobr>
	<a href="/pages/own_auto_edit/?id={$aRow.ua_id}">
		<img src="/image/edit.png" border="0" width="16" align="absmiddle" hspace="1/">
		{$oLanguage->getMessage('edit')}
	</a>&nbsp;
	<a href="{$aRow.tecdoc_url}">
		<img src="/image/icon_ask.gif" border="0" width="16" align="absmiddle" hspace="1/">
		{$oLanguage->getMessage('view_catalog')}
	</a>
	<br />	
	<a href="/pages/vin_request_add_from_garage/?car_id={$aRow.ua_id}">
		<img src="/image/design/plus.gif" border="0" width="16" align="absmiddle" hspace="1/">
		{$oLanguage->getMessage('create_request_vin')}
	</a>&nbsp;
	<a href="/pages/own_auto_del/?id={$aRow.ua_id}">
		<img src="/image/delete.png" border="0" width="16" align="absmiddle" hspace="1/">
		{$oLanguage->getMessage('delete')}
	</a>
</nobr></td>
