<input type=hidden name=action value={$sBaseAction}_apply>
<input type=hidden name=return value="{$sReturn|escape}">

{if !$bHideReturn}
<input type=button value='{$oLanguage->getDMessage('<< Return')}'
 onClick=" xajax_process_browse_url('?{$sReturn|escape}'); return false; " class=submit_button>
{/if}

<INPUT type=submit class="bttn" value='{$oLanguage->getDMessage('Submit')}'>