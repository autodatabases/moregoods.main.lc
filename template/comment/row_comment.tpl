<td >
{$aRow.content}

<p><i>
{$oLanguage->getMessage('Comment from')} <b>{$aRow.name}</b>
{if $aRow.url } ({$aRow.url}) {/if}
—  {$oLanguage->getDateTime($aRow.post)}
</i>
</td>