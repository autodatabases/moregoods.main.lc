<table width=100% border=0>
  	<tr>
   		<td><b>{$oLanguage->getMessage("From name")}:</b></td>
   		<td nowrap><input type="text" name=data[from_name]
			value="{$oLanguage->GetConstant('mail:from_name','Info')}" style="width:500px"></td>
  	</tr>
  	<tr>
   		<td><b>{$oLanguage->getMessage("From mail")}:</b></td>
   		<td nowrap><input type="text" name=data[from]
			value="{$oLanguage->GetConstant('mail:from')}" style="width:500px"></td>
  	</tr>
  	<tr>
   		<td><b>{$oLanguage->getMessage("To")}:</b></td>
   		<td nowrap><input type="text" name=data[to] value="{$aVinRequest.email}" style="width:500px"></td>
  	</tr>
  	<tr>
   		<td><b>{$oLanguage->getMessage("Subject")}:</b></td>
   		<td nowrap id="subject"><input  type="text" name=data[subject] value="{$sSubject}" style="width:500px"></td>
  	</tr>
  	<tr>
   		<td colspan="2" id=template_text>
   		{$sEditor}
   		</td>
  	</tr>
</table>
<input type="hidden" id=id value="{$aVinRequest.id}">