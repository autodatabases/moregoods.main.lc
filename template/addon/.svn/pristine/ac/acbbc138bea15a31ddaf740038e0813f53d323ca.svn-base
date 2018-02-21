{if $sTitle || $sAdditionalTitle}
	<!--div class="title">{$sTitle}{$sAdditionalTitle}{$sHint}</div-->
<div {$sTitleDivHeader}>
<span class="red_box">
{$sTitle}{$sAdditionalTitle}{$sHint}
</span>
</div>
{/if}
	{if $sFormError || $smarty.get.form_error}<div class=error_message>{$sFormError}
		{$oLanguage->getMessage($smarty.get.form_error)}</div>{/if}

	{if $sFormMessage}<div class="{$sFormMessageClass}">{$sFormMessage}</div>{/if}

<FORM {$sHeader}>
{$sHidden}

{if $sRightTemplate}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="{$sWidth}" valign="top">
{/if}

<div class="{$sClass}" style="width:{$sWidth};text-align:left;">
{$sBeforeContent}
	{$sContent}
{$sAfterContent}
</div>



{if $sReturnButton && !$bReturnAfterSubmit}
<span {if $sButtonSpanClass}class="button"{else} style="padding:{$sButtonsPadding}px 0 0 0;" {/if}>
<input type=button class='{$sReturnButtonClass}' value="{$sReturnButton}"
	onclick="location.href='{if !$bNoneDotUrl}.{/if}/{if !$bAutoReturn}?action={/if}{$sReturnAction}'" >
</span>
{/if}


<span {if $sButtonSpanClass && $sSubmitButton}class="button"{else} style="padding:{$sButtonsPadding}px 0 0 0;" {/if}>
{if $sSubmitButton}
<input type=submit class='{$sSubmitButtonClass}' value="{$sSubmitButton}"
	{if $bConfirmSubmit}
		onclick="if (!confirm('{$oLanguage->getMessage($sConfirmText)}')) return false;"
	{/if}
	 >
{/if}

{if $sReturnButton && $bReturnAfterSubmit}
<span {if $sButtonSpanClass}class="button"{else} style="padding:{$sButtonsPadding}px 0 0 0;" {/if}>
<input type=button class='{$sReturnButtonClass}' value="{$sReturnButton}"
	onclick="location.href='{if !$bNoneDotUrl}.{/if}/{if !$bAutoReturn}?action={/if}{$sReturnAction}'" >
</span>
{/if}




{if $sSubmitAction}<input type=hidden name=action value='{$sSubmitAction}'>{/if}

{if $bAutoReturn}
	<input type=hidden name=return value='{$sReturnAction}'>
{/if}

{if $sAdditionalButtonTemplate} {include file=$sAdditionalButtonTemplate} {/if}

{$sAdditionalButton}
</span>

{if $bIsPost}
<input type=hidden name=is_post value='1'>
{/if}

{if $sRightTemplate}
</td>
<td valign="top" style="padding:0 15px">
{include file=$sRightTemplate}
</td>
</tr>
</table>
{/if}

{if $bShowBottomForm}
</FORM>
{/if}