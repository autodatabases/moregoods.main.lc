<input type='hidden' name='is_post' value='1' >
<table class="gm-block-order-filter2">
	<tr>
		<td>{$oLanguage->GetMessage("Sort")}:{$sZir}</td>
		<td>
			<input type=text name=data[sort] value='{$aData.sort}' maxlength=50 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Name")}:{$sZir}</td>
		<td>
			<input id="name" type=text name=data[name] value='{$aData.name}' maxlength=50 style='width:270px'>
		</td>
	</tr>
</table>