<input type="hidden" value="{$oLanguage->getMessage("Form errors")}" id="jsGTform">
<input type="hidden" value="{$oLanguage->getMessage("VIN must contain 17 symbols")}" id="jsGTvin">
<input type="hidden" value="{$oLanguage->getMessage("Model and serie empty")}" id="jsGTmodel">
<input type="hidden" value="{$oLanguage->getMessage("Fill the spareparts list needed")}" id="jsGTazpDescript1">
<input type="hidden" value="{$oLanguage->getMessage("Mobile phone format is incorrect")}" id="jsGTmobile">
{if $oLanguage->GetConstant('vin_request:is_email_necessary',1)}
	<input type="hidden" value="{$oLanguage->getMessage("Email is empty")}" id="jsGTemail">
{/if}


<table style="width:100%">
{if !$aAuthUser.id}
<tr>
   	<td style="width:40%"><b>{$oLanguage->getMessage("Mobile")}:</b>{$sZir}</td>
	<td>
	{if $oLanguage->GetConstant('vin_request:operator_type_select',1)}
	<select name="operator" style="width: 70px;">
		{html_options values=$aVinOperator output=$aVinOperator selected=$aData.operator}
	</select>
	{else}
	<input type=text name=operator value='{$aData.operator}' style="width: 55px;">
	{/if}

	<input type=text id=mobile name=mobile value='{$aData.mobile}'
		maxlength="{$oLanguage->GetConstant('vin_request:phone_digit','9')}" style="width: 185px !important;"><br>
	{$oLanguage->GetMessage("Example")}:{$oLanguage->GetText("vin_request phone example")}
	</td>
</tr>
<tr>
	<td><b>{$oLanguage->GetMessage("Email")}:</b>
		{if $oLanguage->GetConstant('vin_request:is_email_necessary',1)}{$sZir}{/if}
		</td>
	<td><input type=text name=email value='{$aData.email}' ></td>
</tr>
{/if}
	{if $aListOwnAuto}
	<tr>
		<td><b>{$oLanguage->getMessage("Select own auto")}:</b></td>
		<td>
				{html_options options=$aListOwnAuto selected=$aData.id_own_auto name="id_own_auto" style="width: 260px;"
				onchange="javascript:
			       	xajax_process_browse_url('?action=vin_request_change_select_own_auto&amp;id_own_auto='+this.options[this.selectedIndex].value);
			       return false;"}
		</td>
	</tr>
	{/if}
  	<tr>
		<td><b>{$oLanguage->getMessage("VIN")}:</b>{$sZir}</td>
		<td><input type=text id=vin name=vin value='{$aData.vin}' maxlength=17></td>
	</tr>

	{if $oLanguage->GetConstant('vin_request:has_capcha',0)}
	 	<tr>
		<td><b>{$oLanguage->getMessage("Capcha field")}:</b>{$sZir}</td>
		<td valign=top>{$sCapcha}</td>
	</tr>
	{/if}

	<tr>
   		<td style="width:40%"><b>{$oLanguage->getMessage("Marka")}:</b>{$sZir}</td>
   		<td style="width:60%">
		    {html_options name="marka" options=$aVinMarka selected=$aData.marka id='marka' 
			style="width: 260px;" onchange="javascript:
	       		xajax_process_browse_url('?action=vin_request_change_select&amp;data[id_make]='+this.options[this.selectedIndex].value);
	    	    return false;"}
		</td>
  	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("Model/Serie")}:</b>{$sZir}</td>
		<td>
			{html_options options=$aModel selected=$aData.model name="model" id='id_model' style="width: 260px;"}
		</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Wheel")}:</b></td>
		<td>
		<select name="wheel" id='wheel' style="width: 120px;">
		{html_options values=$aVinWheel output=$aVinWheel selected=$aData.wheel}
		</select>
		</td>
	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("Engine")}:</b></td>
		<td><input type=text id=engine name=engine value='{$aData.engine}' ></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Country producer")}:</b></td>
		<td><input type=text id=country_producer name=country_producer value='{$aData.country_producer}' >
   		</td>
  	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Month/Year")}:{$sZir}</b></td>
		<td>
			{html_options name=Month options=$aVinMonth selected=$aData.Month} /

			{html_select_date prefix="" year_extra="style='width:67px'"
				display_days=false time=$aData.date start_year="1959" field_order=Y reverse_years=true}
		</td>
	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("Volume")}:</b></td>
		<td><input type=text id="volume_auto" name=volume value='{$aData.volume}' ></td>
	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("Body")}:</b></td>
		<td>
		    <select id="body_auto" name="body" style="width: 120px;">
			{html_options values=$aVinBody output=$aVinBody selected=$aData.body}
		    </select>
   		</td>
  	</tr>
  	<!-- ���  -->
  	<tr>
		<td><b>{$oLanguage->getMessage("KPP")}:</b></td>
		<td>
			<select id="kpp" name="kpp" style="width: 120px;">
			{html_options  values=$aVinKpp output=$aVinKpp selected=$aData.kpp}
			</select>
   		</td>
  	</tr>
  	<tr>
		<td><b>{$oLanguage->getMessage("Additional")}</b></td>
		<td>
			<input type=checkbox id='add_abs' name='additional[]' value='ABS'
				{if $smarty.request.additional && in_array('ABS',$smarty.request.additional)} checked
				{elseif $aData.is_abs} checked {/if}
				>&nbsp;{$oLanguage->getMessage("ABS")}
			<input type=checkbox id='add_hyd' name='additional[]' value='Hydromultiplier'
				{if $smarty.request.additional && in_array('Hydromultiplier',$smarty.request.additional)} checked 
				{elseif $aData.is_hyd_weel} checked {/if}
				>&nbsp;{$oLanguage->getMessage("Hydromultiplier")}
			<input type=checkbox id='add_cond' name='additional[]' value='Conditioner'
				{if $smarty.request.additional && in_array('Conditioner',$smarty.request.additional)} checked 
				{elseif $aData.is_conditioner} checked {/if}
				>&nbsp;{$oLanguage->getMessage("Conditioner")}
		</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer Comment")}:</b>
		{$oLanguage->getContextHint("vin_request_customer_comment")}
		</td>
		<td><textarea id=customer_comment name=customer_comment style='width:270px'>{$aData.customer_comment}</textarea></td>
	</tr>
	<tr>
   		<td><b>{$oLanguage->getMessage("Passport image (jpg, gif)")}:</b></td>
   		<td><input type=file name=passport_image[1] style='width:270px'></td>
  	</tr>
	<tr>
		<td colspan=2 style="text-align:center;"><hr>{$oLanguage->getText("describe spare parts")}
		</td>
	</tr>

	<tr>
		<td colspan=2 style="text-align:center">

<table id="queryByVIN" style="text-align:center;">
    <tbody>
	{if !$aData.RowCount}
      <tr style="text-align:right;">
        <td>1</td>
        <td><input type="text" name="azpDescript1" maxlength="100" style="width:330px !important;" value=""></td>

        <td><input type="text" name="azpCnt1" maxlength="2" style="width:25px !important;" value="1"></td>
      </tr>
	{else}
		{foreach from=$azp item=zp key=key}
      <tr style="text-align:right;">
        <td>{$key}</td>
        <td><input type="text" name="azpDescript{$key}" maxlength="100" style="width:330px;" value="{$zp.name}"></td>

        <td><input type="text" name="azpCnt{$key}" maxlength="2" style="width:25px;" value="{$zp.cnt}"></td>
      </tr>
		{/foreach}
	{/if}
    </tbody>
</table>

	<br>
      <input type="button" class='btn' value="{$oLanguage->getMessage("Add line")}"
				onclick="javascript:mvr.AddRow(this.form);" />&nbsp;&nbsp;
      <input type="button" class='btn' value="{$oLanguage->getMessage("Delete line")}"
				onclick="javascript:mvr.DeleteRow(this.form);" /><br />&nbsp;

		</td>
	</tr>

</table>

<input type="hidden" name="RowCount" value="{if $aData.RowCount>1}{$aData.RowCount}{else}1{/if}">
<input type="hidden" id="isUserAuth" name="isUserAuth" value="{if $smarty.session.user.id}1{else}0{/if}">
