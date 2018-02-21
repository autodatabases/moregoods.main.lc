<table>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer comment")}:</b></td>
		<td><textarea name=customer_comment style='width:270px'>{$aData.customer_comment}</textarea></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer Database ID")}:</b></td>
		<td><input type=text name=customer_id value='{$aData.customer_id}' maxlength=50 style='width:270px'></td>
	</tr>
</table>