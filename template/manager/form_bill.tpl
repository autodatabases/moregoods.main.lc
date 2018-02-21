<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Customer")}:</b></td>
   		<td>
<select name="id_user">
{section name=d loop=$aUser}
	<option  {if $smarty.request.id_user==$aUser[d].id} selected{/if}
		value="{$aUser[d].id}">{$aUser[d].login} - {$aUser[d].name} (customer_group_name)</option>
{/section}
</select>
   		</td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Bill Template")}:</b></td>
   		<td>
<select name="code_template">
{section name=d loop=$aBillTemplate}
	<option  {if $smarty.request.code_template==$aBillTemplate[d].code} selected{/if}
		value="{$aBillTemplate[d].code}">{$aBillTemplate[d].name}</option>
{/section}
</select>
   		</td>
  	</tr>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Amount")}:</b></td>
   		<td><input type=text name=amount value='{$aData.amount}' maxlength=50 style='width:270px'></td>
  	</tr>
</table>
<input type=hidden name='code_template' value='simple_bill'>