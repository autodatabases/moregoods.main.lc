<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<table width="99%">
	<tr>
	   	<td width=50%><b>{$oLanguage->getMessage("Make")}:{$sZir}</b></td>
   		<td nowrap><select id=pref name=data[pref] style="width:145px">
   		{html_options  options=$aPref selected=$aData.pref}
		</select>
   		</td>
   	</tr>
   	<tr>
	   	<td><b>{$oLanguage->getMessage("Code Part")}:{$sZir}</b></td>
   		<td nowrap><input id=code type="text" name=data[code] value="{$aData.code}">
   		</td>
   	</tr>
   	<tr>
	   	<td width=50%><b>{$oLanguage->getMessage("Make Cross")}:{$sZir}</b></td>
   		<td nowrap><select id=pref name=data[pref_crs]  style="width:145px">
   		{html_options  options=$aPref selected=$aData.pref_crs}
		</select>
   		</td>
   	</tr>
   	<tr>
	   	<td><b>{$oLanguage->getMessage("Code Part Cross")}:{$sZir}</b></td>
   		<td nowrap><input id=code type="text" name=data[code_crs] value="{$aData.code_crs}">
   		</td>
   	</tr>
   	<tr>
	   	<td><b>{$oLanguage->getMessage("Source Crs")}:</b></td>
   		<td nowrap><input id=source type="text" name=data[source] value="{$aData.source}">
   		</td>
   	</tr>
   	
</table>
