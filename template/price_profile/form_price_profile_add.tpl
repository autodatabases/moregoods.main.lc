<table>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Name Profile")}:</b></td>
	<td><input type=text name=data[name] value='{$aData.name}' maxlength=50 style='width:270px'></td>
	</tr>
<!--
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Name Template of File")}:</b></td>
	<td><input type=text name=data[name_file] value='{$aData.name_file}' maxlength=50 style='width:270px'></td>
	</tr>
	{* AT-543 *} 
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Type")}:</b></td>
	<td>{html_options name=data[type_] options=$aType_ selected=$aData.type_ style='width:270px'}</td>
	</tr>
-->
	<input type="hidden" name="data[type_]" value="">
	{* AT-543 *}
<tr>
	<td width=50%><b>{$oLanguage->getMessage("list count")}:</b></td>
	<td><input type=text name=data[list_count] value='{$aData.list_count}' maxlength=50 style='width:270px'></td>
	</tr>		

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Provider or blank")} :</b></td>
	<td>{html_options id="provider_select" name=data[id_provider] options=$aProvider selected=$aData.id_provider style='width:270px'}
	</td>
	<td>
		<a href="" onclick="xajax_process_browse_url('/?action=price_profile_provider_add');$('#popup_id').show();return false;">
  		<img src="/image/plus.png" border=0 width=16 align=absmiddle />{*$oLanguage->getMessage("Message")*}</a>
	</td>
	</tr>

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Provider if provider blank")}:</b></td>
	<td><input type=text name=data[col_provider] value='{$aData.col_provider}' maxlength=10 style='width:270px'></td>
	</tr>	

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coefficient")}:</b></td>
	<td><input type=text name=data[coef] value='{$aData.coef}' maxlength=10 style='width:270px'></td>
	</tr>
	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Delimiter")}:</b></td>
	<td>{html_options name=data[delimiter] options=$aDelimiter selected=$aData.delimiter style='width:270px'}</td>
	</tr>
	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Row Start")}:</b></td>
	<td><input type=text name=data[row_start] value='{$aData.row_start}' maxlength=50 style='width:270px'></td>
	</tr>
	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Name of Catalog or blank")}:</b></td>
	<td>{html_options name=data[pref] options=$aPref selected=$aData.pref style='width:270px'}</td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Name of Catalog")}:</b></td>
	<td><input type=text name=data[col_cat] value='{$aData.col_cat}' maxlength=50 style='width:270px'></td>
	</tr>	

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Code Name")}:</b></td>
	<td><input type=text name=data[col_code_name] value='{$aData.col_code_name}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Name of Part Rus")}:</b></td>
	<td><input type=text name=data[col_part_rus] value='{$aData.col_part_rus}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Name of Part Eng")}:</b></td>
	<td><input type=text name=data[col_part_eng] value='{$aData.col_part_eng}' maxlength=50 style='width:270px'></td>
	</tr>		
<!--tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Multiple")}:</b></td>
	<td><input type=text name=data[col_multiple] value='{$aData.col_multiple}' maxlength=50 style='width:270px'></td>
	</tr-->		
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Number min")}:</b></td>
	<td><input type=text name=data[col_number_min] value='{$aData.col_number_min}' maxlength=50 style='width:270px'></td>
	</tr>		
	
<!--tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Name of Model")}:</b></td>
	<td><input type=text name=data[col_model] value='{$aData.col_model}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Supplier")}:</b></td>
	<td><input type=text name=data[col_supplier] value='{$aData.col_supplier}' maxlength=50 style='width:270px'></td>
	</tr-->	
<tr><td colspan="2"><hr></td></tr>

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Purchase")}:</b></td>
	<td><input type=text name=data[col_price] value='{$aData.col_price}' maxlength=50 style='width:270px'></td>
	</tr>
<!--tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Retail")}:</b></td>
	<td><input type=text name=data[col_price1] value='{$aData.col_price1}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Small-scale")}:</b></td>
	<td><input type=text name=data[col_price2] value='{$aData.col_price2}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Wholesale")}:</b></td>
	<td><input type=text name=data[col_price3] value='{$aData.col_price3}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Large Wholesale")}:</b></td>
	<td><input type=text name=data[col_price4] value='{$aData.col_price4}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Special")}:</b></td>
	<td><input type=text name=data[col_price5] value='{$aData.col_price5}' maxlength=50 style='width:270px'></td>
	</tr>

<tr><td colspan="2"><hr></td></tr>

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Is grp price")}:</b></td>
	<td><input type="hidden" name=data[is_grp] value="0">
   <input type=checkbox name=data[is_grp] value='1' style="width:22px;" {if $aData.is_grp}checked{/if}></td></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Rabat Group")}:</b></td>
	<td><input type=text name=data[col_grp] value='{$aData.col_grp}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Price Base")}:</b></td>
	<td><input type=text name=data[col_price6] value='{$aData.col_price6}' maxlength=50 style='width:270px'></td>
	</tr>	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coef Price Purchase")}:</b></td>
	<td><input type=text name=data[coef_price] value='{$aData.coef_price}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coef Price Retail")}:</b></td>
	<td><input type=text name=data[coef_price1] value='{$aData.coef_price1}' maxlength=50 style='width:270px'></td>
	</tr>
<tr><td colspan="2" align="center">{$oLanguage->getMessage("coef to price retail")}</td></tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coef Price Small-scale")}:</b></td>
	<td><input type=text name=data[coef_price2] value='{$aData.coef_price2}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coef Price Wholesale")}:</b></td>
	<td><input type=text name=data[coef_price3] value='{$aData.coef_price3}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coef Price Large Wholesale")}:</b></td>
	<td><input type=text name=data[coef_price4] value='{$aData.coef_price4}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Coef Price Special")}:</b></td>
	<td><input type=text name=data[coef_price5] value='{$aData.coef_price5}' maxlength=50 style='width:270px'></td>
	</tr-->
	
<tr><td colspan="2"><hr></td></tr>
	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Term")}:</b></td>
	<td><input type=text name=data[col_term] value='{$aData.col_term}' maxlength=50 style='width:270px'></td>
	</tr>	
<!--tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Term Wait")}:</b></td>
	<td><input type=text name=data[col_term_wait] value='{$aData.col_term_wait}' maxlength=50 style='width:270px'></td>
	</tr-->	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Stock")}:</b></td>
	<td><input type=text name=data[col_stock] value='{$aData.col_stock}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage('Cols Stock Associate')}:</td>
	<td><textarea class="inc" style="height:50px;" name=data[assoc_stock] rows='5'>{$aData.assoc_stock|escape}</textarea></td>
	</tr>
<!--tr>
	<td width=50%><b>{$oLanguage->getMessage("Replace Stock")}:<br>
		{$oLanguage->getMessage("Example")} *,+=>1,30</b></td>
	<td><input type=text name=data[replace_stock] value='{$aData.replace_stock}' maxlength=50 style='width:270px'></td>
	</tr>		
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Discount")}:</b></td>
	<td><input type=text name=data[col_discount] value='{$aData.col_discount}' maxlength=50 style='width:270px'></td>
	</tr>

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Is Restored")}:</b></td>
	<td><input type=text name=data[col_is_restored] value='{$aData.col_is_restored}' maxlength=50 style='width:270px'></td>
	</tr-->

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Code In")}:</b></td>
	<td><input type=text name=data[col_code_in] value='{$aData.col_code_in}' maxlength=50 style='width:270px'></td>
	</tr>

<!--tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Cross")}:</b></td>
	<td><input type=text name=data[col_crs] value='{$aData.col_crs}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Weight")}:</b></td>
	<td><input type=text name=data[col_weight] value='{$aData.col_weight}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Email")}:</b></td>
	<td><input type=text name=data[email] value='{$aData.email}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("File name")}:</b></td>
	<td><input type=text name=data[file_name] value='{$aData.file_name}' maxlength=50 style='width:270px'></td>
	</tr-->
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Description")}:</b></td>
	<td><input type=text name=data[col_description] value='{$aData.col_description}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Charset")}:</b></td>
	<td><input type=text name=data[charset] value='{$aData.charset}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Delete Before Insert")}:</b></td>
	<td><input type="hidden" name=data[delete_before] value="0">
   <input type=checkbox name=data[delete_before] value='1' style="width:22px;" {if $aData.delete_before}checked{/if}></td></td>
	</tr>
	<input type=hidden name=data[num] value='{$aData.num}'>
<!--
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Num")}:</b></td>
	<td><input type=text name=data[num] value='{$aData.num}' maxlength=50 style='width:270px'></td>
	</tr>
-->
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Group col")}:</b></td>
	<td><input type=text name=data[col_grp] value='{$aData.col_grp}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Update group")}:</b></td>
	<td><input type="hidden" name=data[update_group] value="0">
   <input type=checkbox name=data[update_group] value='1' style="width:22px;" {if $aData.update_group}checked{/if}></td></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Auto update upload")}:</b></td>
	<td><input type="hidden" name=data[auto_set_price] value="0">
   <input type=checkbox name=data[auto_set_price] value='1' style="width:22px;" {if $aData.auto_set_price}checked{/if}></td></td>
</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Use associate with group")}:</b></td>
	<td><input type="hidden" name=data[is_check_assoc_group] value="0">
   <input type=checkbox name=data[is_check_assoc_group] value='1' style="width:22px;" {if $aData.is_check_assoc_group}checked{/if}></td></td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2" style="text-align: center;">Настройки для сбора прайсов из почтового ящика</td></tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("FileName on mail")} {$oLanguage->GetContextHint('price_profile_filename_template')}:</b></td>
	<td><input type=text name=data[file_name] value='{$aData.file_name}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Email")}:</b>&nbsp;&nbsp;&nbsp;<a class="view_more" href="javascript:;">{$oLanguage->getMessage('view more')}</a></td>
	<td><input type=text name=data[email] value='{$aData.email}' maxlength=50 style='width:270px'></td>
	</tr>
<tr id="email_profile_2" style="display:none">
	<td width=50%><b>{$oLanguage->getMessage("Email")}2:</b></td>
	<td><input type=text name=data[email2] value='{$aData.email2}' maxlength=50 style='width:270px'></td>
	</tr>
<tr id="email_profile_3" style="display:none">
	<td width=50%><b>{$oLanguage->getMessage("Email")}3:</b></td>
	<td><input type=text name=data[email3] value='{$aData.email3}' maxlength=50 style='width:270px'></td>
	</tr>
<tr id="email_profile_4" style="display:none">
	<td width=50%><b>{$oLanguage->getMessage("Email")}4:</b></td>
	<td><input type=text name=data[email4] value='{$aData.email4}' maxlength=50 style='width:270px'></td>
	</tr>
<tr id="email_profile_5" style="display:none">
	<td width=50%><b>{$oLanguage->getMessage("Email")}5:</b></td>
	<td><input type=text name=data[email5] value='{$aData.email5}' maxlength=50 style='width:270px'></td>
	</tr>

</table>
