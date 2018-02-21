<table class="gm-block-order-filter2 no-mobile">
	<tr>
   		<td width=20%>{$oLanguage->getMessage("Name")}:{$sZir}</td>
   		<td><input type=text name=data[name] value='{$aData.name}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("Pref")}:{$sZir} {$oLanguage->getContextHint("catalog_pref")}</td>
   		<td><input type=text name=data[pref] value='{$aData.pref}' style='width:270px' maxlength="3"></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("Title")}:{$sZir}</td>
   		<td><input type=text name=data[title] value='{$aData.title}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("Description")}:</td>
   		<td><textarea name="data[description]" style='width:270px'>{$aData.description}</textarea></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("Descr")}:</td>
   		<td><textarea name="data[descr]" class="ckeditor">{$aData.descr}</textarea></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("id_tof")}:</td>
   		<td><input type=text name=data[id_tof] value='{$aData.id_tof}' maxlength=50 style='width:270px'></td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("is_brand")}:</td>
		<td>{include file="addon/mpanel/form_checkbox.tpl" sFieldName="is_brand" bChecked=$aData.is_brand}</td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("is_main")}:</td>
   		<td>{include file="addon/mpanel/form_checkbox.tpl" sFieldName="is_main" bChecked=$aData.is_main}</td>
  	</tr>
	<tr>
   		<td>{$oLanguage->getMessage("visible")}:</td>
   		<td>{include file="addon/mpanel/form_checkbox.tpl" sFieldName="visible" bChecked=$aData.visible}</td>
  	</tr>
</table>
<input type=hidden name='data[id]' value='{$aData.id}'>