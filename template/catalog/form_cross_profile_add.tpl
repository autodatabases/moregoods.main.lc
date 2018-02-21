<table>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Name Profile")}:</b></td>
	<td><input type=text name=data[name] value='{$aData.name}' maxlength=50 style='width:270px'></td>
	</tr>
	
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Type")}:</b></td>
	<td>{html_options name=data[type_] options=$aType_ selected=$aData.type_ style='width:270px'}</td>
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
	<td width=50%><b>{$oLanguage->getMessage("Col Catalog")}:</b></td>
	<td><input type=text name=data[col_cat] value='{$aData.col_cat}' maxlength=50 style='width:270px'></td>
	</tr>	

<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col Code")}:</b></td>
	<td><input type=text name=data[col_code] value='{$aData.col_code}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col cat crs")}:</b></td>
	<td><input type=text name=data[col_cat_crs] value='{$aData.col_cat_crs}' maxlength=50 style='width:270px'></td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Col code crs")}:</b></td>
	<td><input type=text name=data[col_code_crs] value='{$aData.col_code_crs}' maxlength=50 style='width:270px'></td>
	</tr>		
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Charset")}:</b></td>
	<td><input type=text name=data[charset] value='{$aData.charset}' maxlength=50 style='width:270px'></td>
	</tr>
  	
</table>
