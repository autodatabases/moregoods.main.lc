<td>
<a href='./?action=directory_site_preview&id={$aRow.id}'><h4>{$aRow.url}</h4></a>


{if $aRow.direct_link}
<a href='{$aRow.url}' target=_blank>
{else}
<a href='#' onclick='window.open("{$aRow.url}");'>
{/if}
 {$aRow.name} </a> - {$aRow.description}
<br />

</td>
<td><nobr>{$oLanguage->GetPostDate($aRow.post_date)}</td>