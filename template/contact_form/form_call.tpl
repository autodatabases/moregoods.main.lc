<table class='add_form_table'>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("Ваше имя")}{$sZir}:</b></td>
   		<td > <input type=input name=data[name] value="{$smarty.request.data.name}" style='width:270px'></td>
   	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Ваш e-mail")}<b></b></td>
   		<td > <input type=input name=data[email] value="{$smarty.request.data.email}" style='width:270px'></td>
   	</tr>
	<tr>
		<td ><b>{$oLanguage->getMessage("Номер вашего телефона")}{$sZir}:</b></td>
   		<td > <input type=input name=data[phone] value="{$smarty.request.data.phone}" style='width:270px' class='phone'></td>
   	</tr>
	<tr>
		<td ><b>{$oLanguage->getMessage("Время звонка")}:</b></td>
   		<td >{$oLanguage->getMessage("c")}: <input type=input name=data[time_from] value="{$smarty.request.data.time_from}" style='width:110px'>
   		{$oLanguage->getMessage("до")}:<input type=input name=data[time_to] value="{$smarty.request.data.time_to}" style='width:110px'></td>
   	</tr>
	<tr>
		<td ><b>{$oLanguage->getMessage("Тема")}:</b></td>
   		<td > <input type=input name=data[subject] value="{$smarty.request.data.subject}" style='width:270px'></td>
   	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("Capcha field")}:</b>{$sZir}</td>
		<td valign=top>{$sCapcha}</td>
	</tr>

	<tr>
		<td colspan="2"> <textarea name=data[description] style='width:482px' rows="6">{$smarty.request.data.description}</textarea></td>
   	</tr>
   	<tr>
		<td colspan="2">{$oLanguage->getText("call_text")}</td>
   	</tr>

</table>