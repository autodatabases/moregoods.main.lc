<FORM id='main_form' action='javascript:void(null);'
	onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>{$oLanguage->getDMessage('News item')}</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Section')}:</td>
				<td><select name=data[section]>
 					<option value=site{if $aData.section=='site'} selected{/if}>{$oLanguage->getDMessage('Site News')}</option>
			 		<option value=global{if $aData.section=='global'} selected{/if}>{$oLanguage->getDMessage('Global News')}</option>
				</select></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Date')}:</td>
				<td><input type=text name=data[post_date] value='{$aData.post_date|date_format:"%d-%m-%Y"}'></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Short')}: {$sZir}</td>
				<td><textarea name=data[short]>{$aData.short}</textarea></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Full')}:</td>
				<td>{$oAdmin->getCKEditor('data[full]',$aData.full)}</td>
			</tr>
			{include file='addon/mpanel/form_image.tpl' aData=$aData}
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Page title')}</td>
				<td><textarea name=data[title]>{$aData.title}</textarea></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Page description')}</td>
				<td><textarea name=data[page_description]>{$aData.page_description}</textarea></td>
			</tr>
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Page keyword')}</td>
				<td><textarea name=data[page_keyword]>{$aData.page_keyword}</textarea></td>
			</tr>
			{*<tr>
				<td width="100%">{$oLanguage->getDMessage('URL')}</td>
				<td><textarea name=data[url]>{$aData.url}</textarea></td>
			</tr>*}
			<tr>
				<td width="100%">{$oLanguage->getDMessage('Order Num')}:</td>
				<td><input type=text name=data[num] value="{$aData.num|escape}"></td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('Customer Group')}:{$sZir}</td>
				<td>{html_options name=data[id_customer_group] options=$aCustomerGroupAssoc selected=$aData.id_customer_group}</td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('region')}:{$sZir}</td>
				<td>{html_options name=data[id_region] options=$aRegionList selected=$aData.id_region}</td>
			</tr>
			{include file='addon/mpanel/form_visible.tpl' aData=$aData}

			<tr>
			   <td>{$oLanguage->getDMessage('has_full_link')}:</td>
			   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='has_full_link' bChecked=$aData.has_full_link}</td>
			</tr>
			
			<tr>
			   <td>{$oLanguage->getDMessage('is special')}:</td>
			   <td>{include file='addon/mpanel/form_checkbox.tpl' sFieldName='is_special' bChecked=$aData.is_special}</td>
			</tr>

		</table>

		</td>
	</tr>
</table>

<input type=hidden name=data[id] value="{$aData.id|escape}">
{include file='addon/mpanel/base_add_button.tpl' sBaseAction=$sBaseAction}</FORM>