<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<table width="99%">
	<tr>
	   	<td colspan="2">
	   	{foreach item=aImem from=$aNavigator}
		{if $aImem.name} <span>›</span> {$aImem.name}{/if}
		{/foreach}
   		</td>
   	</tr>
	
   	<tr>
	   	<td colspan="2">
	   	{$sGroup}
	   	<input type="hidden" name="data[id_make]" value="{$smarty.request.data.id_make}">
	   	<input type="hidden" name="data[id_model]" value="{$smarty.request.data.id_model}">
	   	<input type="hidden" name="data[id_part]" value="{$smarty.request.data.id_part}">
	   	<input type="hidden" name="data[id_model_detail]" value="{$smarty.request.data.id_model_detail}">
   		</td>
   	</tr>
	
	<tr>
	   	<td width=50%><b>{$oLanguage->getMessage("Make")}:{$sZir}</b></td>
   		<td nowrap><select id=pref name=data[pref] style="width:145px">
   		{html_options  options=$aPref selected=$aData.pref}
		</select>
   		</td>
   	</tr>
   	<tr>
	   	<td><b>{$oLanguage->getMessage("Code Part")}:{$sZir}</b></td>
   		<td nowrap><input id=code type="text" name=data[code_name] value="{$aData.code_name}">
   		</td>
   	</tr>
</table>
