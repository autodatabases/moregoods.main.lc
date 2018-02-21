<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Code")}:</b></td>
   		<td><input type=text name=code value='{$aData.code}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Price")}:</b></td>
   		<td><input type=text name=price value='{$aData.price}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Number")}:</b></td>
   		<td><input type=text name=number value='{$aData.number}' maxlength=50 style='width:270px'></td>
  	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("New Order Status")}:</b></td>
		<td>
<select name="order_status" style='width:270px'>
{foreach from=$aOrderStatusConfig item=sOrderStatus}
	<option  value="{$sOrderStatus}">{$oLanguage->getMessage($sOrderStatus)}</option>
{/foreach}
</select>
		</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Comment")}:</b><br>
		</td>
		<td><textarea name=manager_comment style='width:270px'>{$aData.manager_comment}</textarea></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Name Translate")}:</b><br>
		</td>
		<td><textarea name=name_translate style='width:270px'>{$aData.name_translate}</textarea></td>
	</tr>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Weight")}:</b>({$oLanguage->getMessage("kg")})</td>
   		<td><input type=text name=weight value='{$aData.weight}' maxlength=50 style='width:270px'></td>
  	</tr>
  		<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Sign")}:</b></td>
   		<td><input type=text name=sign value='{$aData.sign}' maxlength=50 style='width:270px'></td>
  	</tr>
</table>