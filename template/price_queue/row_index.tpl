{foreach key=sKey item=item from=$oTable->aColumn}
{if $sKey=='action'}
<td><nobr>
{if $aRow.is_processed == 2}
  {if $aRow.sum_errors == 0}
	<img src="/image/button_ok.png" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("Work ok")*}
  {else}
  	<img src="/image/button_error.png" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("Work error")*}
  	<a href="" onclick="xajax_process_browse_url('/?action=price_queue_message_show&id={$aRow.id}');$('#popup_id').show();return false;">
  	<img src="/image/message_icon.gif" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("Message")*}</a>
  {/if}
{/if}
{if $aRow.is_processed == 1}
<a href="/?action=price_queue_stop&id={$aRow.id}&return={$sReturn|escape:"url"}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want stopped")}')) return false;"
><img src="/image/stop.png" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("stop")*}</a>
{else}
<a href="/?action=price_queue_edit&id={$aRow.id}&return={$sReturn|escape:"url"}">
<img src="/image/edit.png" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("Edit item")*}</a>
	{if $aRow.is_processed == 0 or $aRow.is_processed == 3}
	<a href="/?action=price_queue_delete&id={$aRow.id}&return={$sReturn|escape:"url"}"
		onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want delete")}')) return false;"
	><img src="/image/delete.png" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("delete")*}</a>
	{/if}
{/if}
</nobr></td>
{elseif $sKey=='pp_name'}
<td><a href="/?action=price_profile_edit&id={$aRow.id_price_profile}&return=action%3Dprice" onclick="StopInterval();">{$aRow.$sKey}</a></td>
{elseif $sKey=='up_name'}
<td><span style="white-space: nowrap;">
{$aRow.$sKey}{$oLanguage->getContextHintProvider($aRow.id_user_provider,$aRow.id)}
{if $aRow.$sKey}
	<a onclick="StopInterval();" href="/?action=price_profile_provider_edit&id={$aRow.id_user_provider}&return=action%3Dprice">
		<img src="/image/edit.png" border="0" width="16">
	</a>
{/if}
</span>
</td>
{elseif $sKey=='file_path'}
<td><a href="/imgbank/price/queue/{$aRow.file_name}">{$aRow.file_name_original}</a>
</td>
{else}
<td>{if $sKey=='sum_all' and $aRow.$sKey eq 0}
	{else}
	 {$aRow.$sKey}
	{/if}
</td>
{/if}
{/foreach}

<!-- td><a href="./?action=manager_auction_response_edit&id={$aRow.id}&return={$sReturn|escape:"url"}">
<img src="/image/edit.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Edit item")}</a>
</td -->
