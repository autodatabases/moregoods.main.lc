<td style="font-size: 9px;">
<b>{$aRow.date}</b><br>
{$aRow.short}
&nbsp; <a href="/?action=news_preview&id={$aRow.id}'>{$oLanguage->getMessage("���������")}</a>
&nbsp; {$oLanguage->getCommentLink('news',$aRow.id,'action=news_preview')}
</td>