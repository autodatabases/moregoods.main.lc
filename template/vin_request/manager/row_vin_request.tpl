<td><b>
{if !$aRow.id_manager_fixed || $aRow.id==$aAuthUser.id_vin_request_fixed}
	<font color=green>
{/if}
	{$aRow.id} </b>
</td>
<td align=center>{$oLanguage->getOrderStatus($aRow.order_status)}</td>
<td>
	{$oLanguage->AddOldParser('customer',$aRow.id_user)}
<br>
<b><a href="/?action=vin_request_manager&search[login]={$aRow.login}'> {$aCountVinRequest[$aRow.id_user]}</a></b> {$aRow.login}
<a href="/?action=vin_request_manager&search[ip]={$aRow.ip}'>{$aRow.ip}</a>
{if $aRow.phone}<br>{$aRow.phone}{/if}
{if $aRow.email}<br>{$aRow.email}{/if}
</td>
<td>{$aRow.vin|upper}</td>
<td>{if !$aRow.id_manager_fixed}<font color=green>{/if}{$oLanguage->getPostDate($aRow.post_date)}</td>
<td>{if $aRow.id_manager_fixed } {$aRow.name_marka} {/if}</td>
<td><div style="width:200px;overflow-x:auto;">
{if $aRow.passport_image_name}<a href='{$aRow.passport_image_name}' target=_blank
	><img src='/image/star_yellow_new.png' border=0></a>{/if}
{if $aRow.customer_comment}&nbsp;{$oLanguage->GetMessage('customer_comment')}:{$aRow.customer_comment}&nbsp;<br>{/if}

{if $aRow.manager_image_name}<a href='{$aRow.manager_image_name}' target=_blank
	><img src='/image/star_yellow_view.png' border=0></a>{/if}
{if $aRow.manager_comment}&nbsp;{$oLanguage->GetMessage('manager_comment')}:{$aRow.manager_comment}&nbsp;{/if}



{if $aRow.order_status=='refused' || $aRow.order_status=='parsed'}
 <br><input type=checkbox value=1 {if $aRow.is_remember}checked{/if}
	onclick=" xajax_process_browse_url('?action=vin_request_manager_remember&id={$aRow.id}&checked='+this.checked);"
	>{$aRow.remember_text}
{/if}
</div>
</td>
<td nowrap>
<a href="/?action=vin_request_manager_edit&id={$aRow.id}&return={$sReturn|escape:"url"}"
	{if !$aRow.id_manager_fixed} style="font-color:green;"{/if}
	><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle />{if $aRow.is_viewed==0}<b>{$oLanguage->getMessage("Preview")}</b>{else}{$oLanguage->getMessage("Preview")}{/if}</a>

<br>
<a href="/?action=vin_request_package_create&id_vin_request={$aRow.id}&return={$sReturn|escape:"url"}"
		><img src="/image/pack2.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Create Package")}</a>

<br><a href="/?action=vin_request_copy&id={$aRow.id}&id_customer_for={$aRow.id_user}&login_customer_for={$aRow.login}"
	><img src="/image/redo.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("Copy as new")}</a>
</td>
