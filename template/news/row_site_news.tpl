<td><ul class="news"><li>
	<label>{$aRow.post_date|date_format:"%d.%m.%Y"}</label>
	{$aRow.short}
	&nbsp;

	{if $aRow.has_full_link}
		<a href="/?action=news_preview&id={$aRow.id}"><b>{$oLanguage->getMessage("News Preview")}&raquo;</b></a>
	{/if}
</li></ul></td>