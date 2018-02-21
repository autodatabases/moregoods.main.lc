<section class="gm-section-content" {if $aAuthUser.type_=='manager'}{$sStyleForm}{/if}>

{$sText}
</section>
{if $aAuthUser}
<aside class="gm-aside-left">

            <nav class="gm-cabinet-menu">
                <div class="caption js-cabinet-menu-toggle">МЕНЮ КАБИНЕТА</div>
                <ul>
	{foreach from=$aAccountMenu item=aItem}
		<li {if $smarty.request.action==$aItem.code}class='selected' {/if}><a href="{if !$aItem.link}/pages/{$aItem.code}{else}{$aItem.code}{/if}">{$aItem.name}
		{if $aAuthUser.type_=='manager'}
			{if $aItem.code=="message"}{if $aTemplateNumber.message_number} <font color="red">({$aTemplateNumber.message_number})</font>{/if}{/if}
			{if $aItem.code=="payment_report_manager"}{if $aTemplateNumber.payment_report_id} <font color="red">({$aTemplateNumber.payment_report_id})</font>{/if}{/if}
			{if $aItem.code=="vin_request_manager"}{if $iNotViewedVins} <font color="red">({$iNotViewedVins})</font>{/if}{/if}
			{if $aItem.code=="manager_package_list"}{if $iNotViewedOrders} <font color="red">({$iNotViewedOrders})</font>{/if}{/if}
			{if $aItem.code=="call_me_show_manager"}{if $aTemplateNumber.resolved} <font color="red">({$aTemplateNumber.resolved})</font>{/if}{/if}
		{/if}
		{if $aAuthUser.type_=='customer'}
			{if $aItem.code=="payment_declaration"}{if $aTemplateNumber.payment_declaration_id} <font color="red">({$aTemplateNumber.payment_declaration_id})</font>{/if}{/if}
			{if $aItem.code=="message_change_current_folder"}{if $aTemplateNumber.message_number} <font color="red">({$aTemplateNumber.message_number})</font>{/if}{/if}
		{/if}
		</a></li>
	{/foreach}
	    <li class="exit"><a href="/pages/user_logout/">{$oLanguage->GetMessage('exit')}</a></li>
	</ul>
	</nav>

{if $aAuthUser.type_=='customer'}
            <div class="gm-block-manager">
                <div class="caption">{$oLanguage->GetMessage('your manager')}</div>
                <div class="name">{$aAuthUser.manager_name}</div>
                <div class="contacts">
                    {if $aAuthUser.manager_phone}<span ><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;&nbsp;{$aAuthUser.manager_phone}</span> <br>{/if}
                    {if $aAuthUser.manager_email}<a  href="mailto:{$aAuthUser.manager_email}"><i class="fa fa-at" ></i>&nbsp;&nbsp;{$aAuthUser.manager_email}</a>{/if}
                 </div>
            </div>
 {elseif $aAuthUser.type_=='manager'}
            <div class="gm-block-manager">
                <div class="caption" style="font-size:16px"><b>{$oLanguage->GetMessage('Мои данные')}</b></div>
                {if $sRegion}<div  class="caption" style="font-size:14px" >{$sRegion}</div>{/if}
                {if $sCustomerGroup}<div  class="caption" style="font-size:14px" >Група: {$sCustomerGroup}</div >{/if}
                <br>
				<div class="name">{$aAuthUser.name}</div>
                <div class="contacts">
                    {if $aAuthUser.phone}<span ><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;&nbsp;{$aAuthUser.phone}</span> <br>{/if}
                    {if $aAuthUser.email}<a class="email" style="font-size:14px" href="mailto:{$aAuthUser.email}">{$aAuthUser.email}</a>{/if}
                 </div>
            </div>
 {*
<div class="gm-block-manager">
    <div class="caption">
    {$oLanguage->getMessage("Select level price")}
    </div>
    <form action="/" class="gm-block-order-filter3 no-mobile">
	<input type="radio" name="type_price" class="css-checkbox" value="user" {if $aAuthUser.type_price == 'user'}checked{/if}>
	<label class="css-label">{$oLanguage->getMessage("user")}:<br>
	{html_options name=data[id_type_price_user] options=$aNameManager selected=$aAuthUser.id_type_price_user id="select_name_user" style="width:172px;"}
	</label>
	<br>
	<input style="margin-top: 11px;" type="radio" name="type_price" class="css-checkbox" value="group" {if $aAuthUser.type_price == 'group' || $aAuthUser.type_price == 'none'}checked{/if}>
	<label class="css-label">{$oLanguage->getMessage("group user")}:<br>
	{if $aAuthUser.id_type_price_group!=0}
		{assign var='id_type_price_group' value=$aAuthUser.id_type_price_group}
	{else}
		{assign var='id_type_price_group' value=$oLanguage->getConstant('IdDefaultPriceGroupManager',1)}
	{/if}                        		
	{html_options name=data[id_type_price_group] id="select_group_user" options=$aPriceGroup selected=$id_type_price_group style="width:172px;"} 
	</label>
	<input name="action" value="user_change_level_price" type="hidden">
	<input name="uri" value="{$sURI}" type="hidden">
	<span style="margin: auto;display: table;">
	<input type="submit" value="{$oLanguage->getMessage('Apply')}" class="atp-button" style="margin-top: 8px;">
	</span>
    </form>
{literal}
<script type="text/javascript">    
$(document).ready(function() {
      $('#select_name_user').select2({
	  minimumInputLength: 2,
	  ajax: {
	    url: "/?action=manager_get_user_select",
	    dataType: 'json',
	    data: function (term, page) {
	      return {
		data: term
	      };
	    },
	    processResults: function (data) {
		  return {
		      results: $.map(data, function (item) {
			  return {
			      text: item.name,
			      id: item.id
			  }
		      })
		  };
	      }
	  }
	});
    $('#select_group_user').select2();
});									
</script>
{/literal}
</div>
*}
{/if}
</aside>
{/if}
<div class="clear"></div>