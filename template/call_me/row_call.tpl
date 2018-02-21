<td>
{$aRow.id}
</td>

<td>
{$aRow.fio}
</td>

<td>
{$aRow.phone}
</td>

<td>
{$aRow.post_date}
</td>

<td>
{if $aRow.resolved}
<span style="color:green">
	{$oLanguage->getMessage('resolved')}
</span>
{else}
<span style="color:red">
	{$oLanguage->getMessage('not resolved')}
</span>
{/if}
</td>
<td>
{if !$aRow.resolved}
<a href="/pages/call_me_show_manager/?id={$aRow.id}">{$oLanguage->getMessage('resolve')}</a>
{/if}
</td>
