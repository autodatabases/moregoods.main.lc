<table class="gm-block-order-filter2 no-mobile">
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("vin")}:</b>{$sZir}</td>
		<td><input type=text maxlength=17 name=data[vin] value=
		'{if (!$smarty.request.data.vin)}{$aData.vin}{else}{$smarty.request.data.vin}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		{if (!$smarty.request.data.id_make)}
			{assign var="sel_type_make" value=$aData.id_make}
		{else}
			{assign var="sel_type_make" value=$smarty.request.data.id_make}
		{/if}	
		<td width="100px"><b>{$oLanguage->getMessage("Make")}:</b>{$sZir}</td>
		<td><select id="ctlMakeOwnAuto" name="data[id_make]" style="width: 160px;" onchange="change_MakeAuto(this);">
			{html_options options=$aMake selected=$sel_type_make}
			</select>
		</td>
	</tr>
	<tr>
		{if (!$smarty.request.data.id_model)}
			{assign var="sel_type_model" value=$aData.id_model}
		{else}
			{assign var="sel_type_model" value=$smarty.request.data.id_model}
		{/if}	
		<td><b>{$oLanguage->getMessage("Model")}:</b>{$sZir}</td>
		<td><select id="ctlModelOwnAuto" name="data[id_model]" style="width: 160px;">
			{html_options options=$aModel selected=$sel_type_model}
			</select>
		</td>
	</tr>
	<tr>
		{if (!$smarty.request.data.id_wheel)}
			{assign var="sel_type_wheel" value=$aData.wheel}
		{else}
			{assign var="sel_type_wheel" value=$smarty.request.data.wheel}
		{/if}
		<td><b>{$oLanguage->getMessage("type_wheel")}:</b></td>
		<td><select id="type_wheel" name="data[wheel]" style="width: 160px;"">
			{html_options options=$aTypeWheel selected=$sel_type_wheel}
			</select>
		</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("engine")}:</b></td>
		<td><input type=text name=data[engine] value=
		'{if (!$smarty.request.data.engine)}{$aData.engine}{else}{$smarty.request.data.engine}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("country_producer")}:</b></td>
		<td><input type=text name=data[country_producer] value=
			'{if (!$smarty.request.data.country_producer)}{$aData.country_producer}{else}{$smarty.request.data.country_producer}{/if}'
			maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Month/Year")}:{$sZir}</b></td>
		<td>
			{if (!$smarty.request.data.month)}
				{assign var="sel_type_month" value=$aData.month}
			{else}
				{assign var="sel_type_month" value=$smarty.request.data.month}
			{/if}
			{html_options name=data[month] options=$aVinMonth selected=$sel_type_month} /

			{if (!$smarty.request.Year)}
				{assign var="sel_type_year" value=$aData.date}
			{else}
				{assign var="sel_type_year" value="`$smarty.request.Year`-01-01"}
			{/if}
			{html_select_date prefix="" year_extra="style='width:67px'"
				display_days=false time=$sel_type_year start_year="1959" field_order=Y reverse_years=true}
		</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("volume")}:</b>{$sZir}</td>
		<td><input type=text name=data[volume] value=
		'{if (!$smarty.request.data.volume)}{$aData.volume}{else}{$smarty.request.data.volume}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		{if (!$smarty.request.data.body)}
			{assign var="sel_type_body" value=$aData.body}
		{else}
			{assign var="sel_type_body" value=$smarty.request.data.body}
		{/if}
		<td><b>{$oLanguage->getMessage("body")}:</b></td>
		<td><select id="type_body" name="data[body]" style="width: 160px;"">
			{html_options options=$aTypeBody selected=$sel_type_body}
			</select>
		</td>
	</tr>
	<tr>	
		{if (!$smarty.request.data.kpp)}
			{assign var="sel_type_transmission" value=$aData.kpp}
		{else}
			{assign var="sel_type_transmission" value=$smarty.request.data.kpp}
		{/if}
		<td><b>{$oLanguage->getMessage("kpp")}:</b></td>
		<td><select id="type_transmission" name="data[kpp]" style="width: 160px;"">
			{html_options options=$aTypeTransmission selected=$sel_type_transmission}
			</select>
		</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_abs")}:</b></td>
		<td><input type="hidden" name=data[is_abs] value="0">
	   		<input type=checkbox name=data[is_abs] value='1' style="width:22px;"
	   		{if ($smarty.request.data.is_abs == 1)}checked{elseif $aData.is_abs}checked{/if}
	   		>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_hyd_weel")}:</b></td>
		<td><input type="hidden" name=data[is_hyd_weel] value="0">
	   		<input type=checkbox name=data[is_hyd_weel] value='1' style="width:22px;"
	   		{if ($smarty.request.data.is_hyd_weel == 1)}checked{elseif $aData.is_hyd_weel}checked{/if}
	   		>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_conditioner")}:</b></td>
		<td><input type="hidden" name=data[is_conditioner] value="0">
	   		<input type=checkbox name=data[is_conditioner] value='1' style="width:22px;"
	   		 {if ($smarty.request.data.is_conditioner == 1)}checked{elseif $aData.is_conditioner}checked{/if}
	   		 >
	   	</td>
	</tr>
	<tr>
		<td valign=top><b>{$oLanguage->getMessage("customer_comment")}:</b></td>
		<td><textarea name=data[customer_comment] style='width:286px'
		>{if (!$smarty.request.data.customer_comment)}{$aData.customer_comment}{else}{$smarty.request.data.customer_comment}{/if}</textarea>
		</td>
	</tr>
	

	<!--
	<tr>
		{if (!$smarty.request.data.id_type_drive)}
			{assign var="sel_type_drive" value=$aData.id_type_drive}
		{else}
			{assign var="sel_type_drive" value=$smarty.request.data.id_type_drive}
		{/if}	
		<td><b>{$oLanguage->getMessage("type_drive")}:</b></td>
		<td><select id="type_drive" name="data[id_type_drive]" style="width: 390px;"">
			{html_options options=$aTypeDrive selected=$sel_type_drive}
			</select>
		</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("engine_power")}:</b>{$sZir}</td>
		<td><input type=text name=data[engine_power] value=
		'{if (!$smarty.request.data.engine_power)}{$aData.engine_power}{else}{$smarty.request.data.engine_power}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("cnt_cylinders")}:</b></td>
		<td><input type=text name=data[cnt_cylinders] value=
		'{if (!$smarty.request.data.cnt_cylinders)}{$aData.cnt_cylinders}{else}{$smarty.request.data.cnt_cylinders}{/if}'
		 maxlength=5 style='width:50px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("cnt_valves")}:</b></td>
		<td><input type=text name=data[cnt_valves] value=
		'{if (!$smarty.request.data.cnt_valves)}{$aData.cnt_valves}{else}{$smarty.request.data.cnt_valves}{/if}'
		 maxlength=5 style='width:50px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("code_engine")}:</b></td>
		<td><input type=text name=data[code_engine] value=
		'{if (!$smarty.request.data.code_engine)}{$aData.code_engine}{else}{$smarty.request.data.code_engine}{/if}'
		 maxlength=200 style='width:386px'></td>
	</tr>
	<tr>
		{if (!$smarty.request.data.id_type_fuel)}
			{assign var="sel_type_fuel" value=$aData.id_type_fuel}
		{else}
			{assign var="sel_type_fuel" value=$smarty.request.data.id_type_fuel}
		{/if}	
		<td><b>{$oLanguage->getMessage("type_fuel")}:</b></td>
		<td><select id="type_fuel" name="data[id_type_fuel]" style="width: 390px;"">
			{html_options options=$aTypeFuel selected=$sel_type_fuel}
			</select>
		</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("type_fuel_supply")}:</b></td>
		<td><input type=text name=data[type_fuel_supply] value=
		'{if (!$smarty.request.data.type_fuel_supply)}{$aData.type_fuel_supply}{else}{$smarty.request.data.type_fuel_supply}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("type_break")}:</b></td>
		<td><input type=text name=data[type_break] value=
		'{if (!$smarty.request.data.type_break)}{$aData.type_break}{else}{$smarty.request.data.type_break}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("type_front_break")}:</b></td>
		<td><input type=text name=data[type_front_break] value=
		'{if (!$smarty.request.data.type_front_break)}{$aData.type_front_break}{else}{$smarty.request.data.type_front_break}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("type_rear_break")}:</b></td>
		<td><input type=text name=data[type_rear_break] value=
		'{if (!$smarty.request.data.type_rear_break)}{$aData.type_rear_break}{else}{$smarty.request.data.type_rear_break}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("code_transmission")}:</b></td>
		<td><input type=text name=data[code_transmission] value=
		'{if (!$smarty.request.data.code_transmission)}{$aData.code_transmission}{else}{$smarty.request.data.code_transmission}{/if}'
		 maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("transmission_count")}:</b></td>
		<td><input type=text name=data[transmission_count] value=
		'{if (!$smarty.request.data.transmission_count)}{$aData.transmission_count}{else}{$smarty.request.data.transmission_count}{/if}'
		 maxlength=2 style='width:50px'></td>
	</tr>
	
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_asr")}:</b></td>
		<td><input type="hidden" name=data[is_asr] value="0">
	   		<input type=checkbox name=data[is_asr] value='1' style="width:22px;"
			{if ($smarty.request.data.is_asr == 1)}checked{elseif $aData.is_asr}checked{/if}
			>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_asd")}:</b></td>
		<td><input type="hidden" name=data[is_asd] value="0">
	   		<input type=checkbox name=data[is_asd] value='1' style="width:22px;"
	   		{if ($smarty.request.data.is_asd == 1)}checked{elseif $aData.is_asd}checked{/if}
	   		>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_esp")}:</b></td>
		<td><input type="hidden" name=data[is_esp] value="0">
	   		<input type=checkbox name=data[is_esp] value='1' style="width:22px;"
	   		{if ($smarty.request.data.is_esp == 1)}checked{elseif $aData.is_esp}checked{/if}
	   		>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_catalyst")}:</b></td>
		<td><input type="hidden" name=data[is_catalyst] value="0">
	   		<input type=checkbox name=data[is_catalyst] value='1' style="width:22px;"
	   		{if ($smarty.request.data.is_catalyst == 1)}checked{elseif $aData.is_catalyst}checked{/if}
	   		>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("type_catalyst")}:</b></td>
		<td><input type=text name=data[type_catalyst] value=
		'{if (!$smarty.request.data.type_catalyst)}{$aData.type_catalyst}{else}{$smarty.request.data.type_catalyst}{/if}'
		maxlength=50 style='width:386px'></td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("is_turbo")}:</b></td>
		<td><input type="hidden" name=data[is_turbo] value="0">
	   		<input type=checkbox name=data[is_turbo] value='1' style="width:22px;" 
	   		{if ($smarty.request.data.is_turbo == 1)}checked{elseif $aData.is_turbo}checked{/if}
	   		>
	   	</td>
	</tr>
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("cnt_door")}:</b></td>
		<td><input type=text name=data[cnt_door] value=
			'{if (!$smarty.request.data.cnt_door)}{$aData.cnt_door}{else}{$smarty.request.data.cnt_door}{/if}'
			 maxlength=2 style='width:50px'></td>
	</tr>

	<tr>
		<td width=50%><b>{$oLanguage->getMessage("gov_code")}:</b></td>
		<td><input type=text name=data[gov_code] value=
			'{if (!$smarty.request.data.gov_code)}{$aData.gov_code}{else}{$smarty.request.data.gov_code}{/if}'
			maxlength=50 style='width:386px'></td>
	</tr>
-->	
</table>
