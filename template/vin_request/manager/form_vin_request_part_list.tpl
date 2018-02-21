<script type="text/javascript" src="/js/vin_request.js?844"></script>
<br>
<br>

{if $smarty.request.form_message}<div class=error_message>{$smarty.request.form_message}</div>{/if}

<table width="99%" cellspacing=0 cellpadding=5 class="datatable">
<tr>
	<th><nobr>{$oLanguage->getMessage("#")}</th>
	<th width=5><nobr>{$oLanguage->getMessage("Visible")}</th>
	<th width=20%><nobr>{$oLanguage->getMessage("Name")}</th>
	<th><nobr>{$oLanguage->getMessage("Code")}</th>
	<th><nobr>{$oLanguage->getMessage("UserInputCode")}</th>
	<th><nobr>{$oLanguage->getMessage("Number")}</th>
	<th><nobr>{$oLanguage->getMessage("Weight")}</th>
	<th><nobr>{$oLanguage->getMessage("Price")}</th>
</tr>
{foreach item=aPart from=$aPartList}
<tr class="{cycle values="even,none"}">
	<td>{$aPart.i} <input type=checkbox name="part[{$aPart.i}][i]" value='1'
		{if $aPart.i_visible}checked{/if}></td>
	<td align=center><input type=checkbox name="part[{$aPart.i}][code_visible]" value='1'
		{if $aPart.code_visible}checked{/if}></td>
	<td><input type=text name="part[{$aPart.i}][name]" value="{$aPart.name}" style="width:250px;"></td>
	<td><input type=text name="part[{$aPart.i}][code]" value="{$aPart.code}"></td>
	<td><input type=text name="part[{$aPart.i}][user_input_code]" value="{$aPart.user_input_code}"></td>
	<td><input type=text name="part[{$aPart.i}][number]" value="{$aPart.number}" style="width:50px;"></td>
	<td><input type=text name="part[{$aPart.i}][weight]" value="{$aPart.weight}" style="width:30px;"
		> {$oLanguage->GetMessage('kg')}</td>
	<td>{if $aPart.price}{$oCurrency->PrintPrice($aPart.price)}{/if}</td>
</tr>
{/foreach}
</table>

<input type="hidden" name="RowCount" value="{$iRowCount}">

<table width="99%" cellspacing=0 cellpadding=5 class="datatable"  id="queryByVIN">
    <tbody>
<tr class="even">
	<td></td>
	<td></td>
	<td align=center></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
    </tbody>
</table>

<div align=center style="padding:5px 0 0 0;">
<input type="button" class='btn' value="{$oLanguage->getMessage("Add line")}" onclick="javascript:mvr.AddManagerRow(this.form);"
		/>&nbsp;&nbsp;
</div>


<div style="padding:5px 0 0 0;">
<input type=button class='btn' value="{$oLanguage->getMessage(" << Return")}"
		onclick="location.href='./?{if $smarty.request.return}{$smarty.request.return}{else}action=vin_request_manager{/if}'" >
<input type=button class='btn' value="{$oLanguage->getMessage("Save")}"
	onclick="this.form.elements['action'].value='vin_request_manager_save'; this.form.submit();">

<input type=button class='btn' value="{$oLanguage->getMessage("Send to customer")}"
	onclick="
this.form.elements['section'].value='customer';
this.form.elements['action'].value='vin_request_manager_send'; this.form.submit();">

<input type=button class='btn' value="{$oLanguage->getMessage("Refuse Request")}" style="color: red;"
	onclick="if (confirm('{$oLanguage->getMessage("Are you sure to refuse?")}')) {ldelim}
		this.form.elements['action'].value='vin_request_manager_refuse'; this.form.submit();{rdelim}">


<input type=button class='btn' value="{$oLanguage->getMessage("Send preview to customer")}"
	onclick="
this.form.elements['section'].value='customer';
this.form.elements['action'].value='vin_request_manager_send_preview'; this.form.submit();">



<input type=hidden name=action value=''>
<input type=hidden name=section value='cart'>
<input type=hidden name=is_post value='1'>

</div>



{*if $smarty.get.id==$aAuthUser.id_vin_request_fixed}
<br>
<div align=center>
<input type=button class='btn' value="{$oLanguage->getMessage("Refuse for")}"
	onclick="
this.form.elements['section'].value='customer';
this.form.elements['action'].value='vin_request_manager_refuse_for'; this.form.submit();">
<select name="data[refuse_for]">
{html_options options=$aManagerLogin}
</select>

</div>
{/if*}


</FORM>