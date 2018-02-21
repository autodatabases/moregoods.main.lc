<input type='hidden' name='is_post' value='1' >
<table class="gm-block-order-filter2 no-mobile">
	<tr>
		<td>{$oLanguage->GetMessage("Date and time send")}:
		<br>{$oLanguage->GetText("If empty - get current date and time. Use format: d-m-Y H:i:s")}</td>
		<td>
			<input type=text name=data[date_send] value='{if $smarty.request.data.date_send}{$smarty.request.data.date_send}{else}{$aData.date_send}{/if}' maxlength=50 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Select user")}:</td>
		<td>
			<input id="sel_user_auto" type=text name=data[login] value='{if $smarty.request.data.login}{$smarty.request.data.login}{else}{$aData.login}{/if}' maxlength=50 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Recipient")}:<td>
			<input type=text name=data[recipient] value='{if $smarty.request.data.recipient}{$smarty.request.data.recipient}{else}{$aData.recipient}{/if}' maxlength=250 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Carrier")}:<td>
			<input type=text name=data[carrier] value='{if $smarty.request.data.carrier}{$smarty.request.data.carrier}{else}{$aData.carrier}{/if}' maxlength=250 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td>{$sZir}&nbsp;{$oLanguage->GetMessage("Number declaration")}:</td>
		<td><input type=text name=data[number_declaration] value='{$aData.number_declaration}' maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td>{$sZir}&nbsp;{$oLanguage->GetMessage("Number places")}:</td>
		<td><input type=text name=data[number_places] value='{$aData.number_places}' maxlength=10 style='width:270px'></td>
	</tr>
</table>