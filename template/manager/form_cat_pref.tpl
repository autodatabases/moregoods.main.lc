<table class="gm-block-order-filter2 no-mobile">
	<tr>
   		<td width=20%>{$oLanguage->getMessage("Name")}:{$sZir}</td>
   		<td><input type=text name=data[name] value='{$aData.name}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("Pref")}:{$sZir}</td>
   		<td>{html_options name=data[cat_id] options=$aPrefAssoc selected=$aData.cat_id style='width:270px'}
			{*<input type=text name=data[pref] value='{$aData.pref}' maxlength=50 style='width:270px'>*}</td>
  	</tr>
</table>
<input type=hidden name='data[id]' value='{$aData.id}'>