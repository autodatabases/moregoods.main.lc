<script type="text/javascript" src="/libp/js/table.js"></script>

{if $sHeader}
{/if}

{if $smarty.get.table_error}
<div class="error_message">{$oLanguage->getMessage($smarty.get.table_error)}</div>
{/if}


{if $bFormAvailable}<form id="table_form" {$sFormHeader}>{/if}

<ul class="notices">
{if $bHeaderVisible}
<tr>
	{if $bCheckVisible}<th><input type=checkbox name=check_all
		onclick="mt.SetCheckboxes(this.form,this.checked);" {if $bDefaultChecked}checked{/if} ></th>
	{/if}

{foreach key=key item=aValue from=$aColumn}
	<th {if $aValue.sWidth} width="{$aValue.sWidth}"{/if}><nobr>{$aValue.sTitle}{if !$aValue.sTitle}&nbsp;{/if}</th>
{/foreach}
</tr>
{/if}


{section name=d loop=$aItem}
<li><ul>
{assign var=aRow value=$aItem[d]}
	{if $bCheckVisible}<td><input type=checkbox name=row_check[]
		id='row_check_{$smarty.section.d.index}' value='{$aRow.$sCheckField}' {if $bDefaultChecked} checked{/if} ></td>
	{/if}
{include file=$sDataTemplate}
</ul></li>
{/section}


{if $sSubtotalTemplate} {include file=$sSubtotalTemplate} {/if}

{if $sStepper}
	{$sStepper}
{/if}

</ul>

<div style="padding: 5px;">
{if $sButtonTemplate} {include file=$sButtonTemplate} {/if}

{if $sAddButton}
<input type=button value="{$sAddButton}" onclick="location.href='./?action={$sAddAction}'" >
{/if}
</div>


{if $bFormAvailable}
<input type=hidden name=action id='action' value='empty'>
<input type=hidden name=return id='return' value=''>
</form>
{/if}