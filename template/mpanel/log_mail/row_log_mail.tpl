<td>{$aRow.id}</td>
<td><b>{$aRow.address}</b> {if $aRow.description}<br>{$aRow.description}{/if}</td>
<td><b>{$aRow.from_email}</b><br>{$aRow.from_name}</td>
<td>{$aRow.subject}<br>
{if $aRow.attach_code}<b>{$oLanguage->GetDMessage('attach_code')}: {$aRow.attach_code}</b>{/if}
</td>
<td>{$oLanguage->GetDateTime($aRow.post)}<br><b>{$oLanguage->GetDateTime($aRow.sent_time)}</b></td>
<td>{$aRow.priority}</td>
<td>
{include file='addon/mpanel/base_row_preview.tpl' sBaseAction=$sBaseAction}
</td>