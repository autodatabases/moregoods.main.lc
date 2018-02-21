{*
<table border="0" cellpadding="1" cellspacing="1" width="550">
<form>
<input type=hidden name=action value='manual'>
<tr>
	<td><nobr><h3>{$oLanguage->getMessage("Select Category")}</h3></td>
	<td>
<select name="id_manual_category" onchange="this.form.submit()" style="width: 250px;">
{section name=d loop=$aManualCategory}
<option  {if $smarty.request.id_manual_category==$aManualCategory[d].id} selected{/if}
	value="{$aManualCategory[d].id}">{$aManualCategory[d].name}</option>
{/section}
</select>{$oLanguage->getContextHint("manual_select")}
	</td>
</tr>
</form>
</table>


{if $aAuthUser.type_=='customer'}
*}


<ul class="secodary_tabs">
{foreach item=aItem from=$aManualCategory}
	<li class="{if $aManualCategoryCurrent.code==$aItem.code}sel{/if}"
		><a href='/?action=manual&code_manual_category={$aItem.code}'
		>{$aItem.name}</a></li>
{/foreach}
</ul>

<br />

{section name=d loop=$aManual}
<a href="#q_{$aManual[d].id}" class="a3">{$aManual[d].name}</a><br>
{/section}


{section name=d loop=$aManual}
<p>
<a name="q_{$aManual[d].id}"></a>

<h3>{$aManual[d].name}</h3>

{$aManual[d].content}
</p>

{/section}