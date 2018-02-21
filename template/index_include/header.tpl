                     <script>
                     $('body').removeClass().addClass('{$sClassBrand}');
                     </script>
                     {include file="catalog/cart_popup.tpl"}
<div class="gm-block-brand-color"></div>

<div class="gm-block-preheader">
    <div class="gm-mainer">
    
        {*if $aAuthUser.type_!='manager'*}
        {*<div class="city-choose">
        <label>
            <span class="block-region" >{$oLanguage->getMessage('region')}:</span>
            <select data-placeholder="{$oLanguage->GetMessage('select city')}" class="chosen-select" tabindex="2">
            {html_options options=$aCity selected=$sSelectedCity}
            </select>
            <span class="clear"></span>
        </label>
              {if !$aAuthUser}
                        <div class="sub js-location-sub" {if $sSelectedCityFirst} style="display: none;"{else}style="display: block;"{/if}>
                    Ваш регiон <br><strong>
                    {if $aCity[$sSelectedCity]}
                    {$aCity[$sSelectedCity]}
                    {else}
                    {$sSelectedCity}
                    {/if}
                    </strong>?
                    <div class="buttons">
                        <a href="javascript:void(0);" class="gm-button js-location-yes">Так</a>
                        <a href="javascript:void(0);" class="gm-button button-cancel js-location-no">Нi</a>
                        <div class="clear"></div>
                    </div>
                </div>
              {/if}  
        </div>*}
        {*/if*}
        <div class="block-phones"  id ="block-phones" style="float: right; font-size: 30px;"><i class="fa fa-phone-square" aria-hidden="true"></i>
        {*$sPhone1*}
        {*if $sPhone2}  &nbsp;&nbsp;{$sPhone2} {/if*}
            {$oLanguage->GetConstant('global:project_phone')}
        </div>

        <span class="top_links">{$oLanguage->GetText('top_links')}</span>

        {if $aAuthUser.type_=='customer'}
            {literal}<style>
                .chosen-drop{
                    display:none;
                }
            </style>{/literal}
        {/if}
        <div class="clear"></div>
    </div>
</div>

<header class="gm-block-header">
    <div class="gm-mainer">
        <div class="block-logo"><a href="/"><img src="/image/_images/logo2.png" alt="" width=120 height= 120></a>
        {*<span class="sale"><a class="button" href="/?action=catalog_promo&group=0&promo=3">{$oLanguage->getMessage('Sale')}</a></span>*}</div>
        <div class="block-toggle js-block-left-curtain-toggle"></div>
        	<div class="words" id="wrap1"><h2  style="margin-bottom: 26px;"><a class="mainlog" href="/">Роспись футболок акрилом</a></h2>
                <h6><em><center>(сделано с душой)</center></em></h6>
					<div class="post-detail">
            				<span class="post-info">
                      			<span>				{$currentDate}							</span>
            </span>
    </div></div>
        {literal}<style type="text/css">

@keyframes anim{
from {margin-left:-603px;}
to {margin-left:0px;}
}
@-moz-keyframes anim{
from {margin-left:-603px;}
to {margin-left:0px;}
}
@-webkit-keyframes anim{
from {margin-left:-603px;}
to {margin-left:0px;}
}
#wrap1{
animation:anim 0.5s 1;
-webkit-animation:anim 0.5s 1;
}
</style>{/literal}
        
        

        <div class="block-auth">
            <a class="link-favorite" href="/pages/favourites"><i class="fa fa-heart" aria-hidden="true"></i><span  id="ifav_id" class="count">{$favNum}</span></a>
            <a class="link-basket" href="/pages/cart_cart"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span id="icart_id" class="count avail">{$aTemplateNumber.cart_total}</span></a>&nbsp;
            {*<a href="http://moregoods.com.ua/" class="lang1" style="    margin: -126px 0 0 0;">UA</a>
<a href="http://ru.moregoods.com.ua/" class="lang2" style="    margin: -126px 0 0 0;">RU</a>*}
            {if $aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login)) }
            <div class="drop-wrap">
                <a href="#"><span class="gm-link-dashed">{$oLanguage->getMessage('my_dash')}</span></a>
                <div class="sub">
                {foreach from=$aAccountMenu item=aItem}
                <a href="/pages/{if !$aItem.link}{$aItem.code}{else}{$aItem.code}{/if}">{$aItem.name}
                            {if $aAuthUser.type_=='manager'}
                                {if $aItem.code=="message"}{if $aTemplateNumber.message_number} <span class="count">({$aTemplateNumber.message_number})</span>{/if}{/if}
                                {if $aItem.code=="message_change_current_folder"}{if $aTemplateNumber.message_number} <span class="count">({$aTemplateNumber.message_number})</font>{/if}{/if}
                                {if $aItem.code=="vin_request_manager"}{if $iNotViewedVins} <span class="count">({$iNotViewedVins})</span>{/if}{/if}
                                {if $aItem.code=="manager_package_list"}{if $iNotViewedOrders} <span class="count">({$iNotViewedOrders})</span>{/if}{/if}
                            {/if}</a>
                            {/foreach}
                            <a href="/pages/user_logout">{$oLanguage->GetMessage('exit')}</a>
                </div>
            </div>
            <div class="user-name" style="text-align: right;padding: 4px 0 0 0;">{$aAuthUser.name}{if $aAuthUser.type_=='manager'}&nbsp;&nbsp;&nbsp;({$sCustomerGroup}) {$sCustomerPartner}{/if}
            </div>
            {else}
            <a class=" login_to_personal_area log2" href="javascript:void(0);" onclick="popupOpen('.js-popup-auth');">{$oLanguage->getMessage('enter_cab')}/ <br>{$oLanguage->getMessage('new registration')}</a>
            
            {/if}
            {*if $aAuthUser.id && $aAuthUser.is_bonus==1}
            
            {if $aBonus >=0 }
            <p class="bonus_p" style="color: green; text-align: right;">{$oLanguage->getMessage('bonus')}:&nbsp;
                {$oCurrency->PrintPrice($aBonus)}</p>
            {elseif $aBonus < 0}
            <p class="bonus_p" style="color: red; text-align: right;">{$oLanguage->getMessage('dolg')}:&nbsp;{$oCurrency->PrintPrice($aBonus)}<br>
                <a style="color: #5fb7c1;" class="gm-link-dashed" target="_blank" href="/pages/finance_user_debt?search_dist=0&search%5Bis_debt%5D=is&action=finance_user_debt">Детальніше</a></p>
            {/if}{/if}
        
            {if $aAuthUser.id && $aBonus < 0 && $aAuthUser.customer_group_name == 'B2B'}
            <p class="bonus_p" style="color: red; text-align: right;">{$oLanguage->getMessage('dolg')}:&nbsp;{$oCurrency->PrintPrice($aBonus)}</p>{/if*}
        </div>
        <div class="graf" style="">{*$oLanguage->GetText('grafic')*}</div>
        {*<div class="block-search">
        <form class="at-search-from" action="/">
        <input name="action" value="catalog_price_view" type="hidden"/>
        <input name="only_by_name" value="1" type="hidden"/>
            <input class="search_sphinx" type="text" name="code" value="{$smarty.get.code}" placeholder="{$oLanguage->getMessage('search_goods')}">
            <input type="submit" value="">
        </form>    
        </div>*}
        
        <div class="clear"></div>

    </div>
</header>

<nav class="gm-block-category-nav">
    <div class="gm-mainer">
    <ul>
    {foreach from=$EcBrandGroup item=BrandGroup key=id}
    {if $smarty.get.group == $id}
    <li class="gm_item selected">
        {elseif $smarty.request.action=='catalog_product'}
                {if $iIdBrandGroup}
                    {if $iIdBrandGroup==$id}
                     <li class="gm_item selected">
                     {else}
                     <li class="gm_item">
                     {/if}
                {else}
                <li class="gm_item">
                {/if}
            {else}
            <li class="gm_item">
            {/if}
            <a class="gm_brand_group" id="{$BrandGroup.name}" href="/?action=catalog_vid&group={$id}">{$BrandGroup.name}</a>
            {if $OLD_Interface}
                {*  Меню с брендами *}
                {if $BrandGroup.sub}
                <div class="sub">
                {foreach from=$BrandGroup.sub item=Item key=id2}
                    <a class="child-element" href="/?action=catalog_brand&group={$id}&brand={$Item.id_brand}">
                        <span class="image"><span><img src={$Item.image} alt="{$Item.brand}"></span></span>
                        <span class="name gm-link-dashed">{$Item.brand}</span>
                    </a>
                {/foreach}
                <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                </div>
                {/if}
            {else}
            {* Меню с видами*}
            <div class="gm_vids" style="display: none !important;">
             <div class="gm_columns">
              <div class="gm_column left-list">
                <ul class="gm_column-left-list"> {* Новинки     Распродажа  Ptomo TV  *}
                {foreach from=$BrandGroup.biglist item=aBigListItem }
                    {if !$B2C_Interface || $B2C_Interface==1 && $aBigListItem.types!=4 || ($smarty.request.brand == $aBigListItem.id && $aBigListItem.types==4)}
                    <ul class="gm_column-left-list__item ">
                    <a class="gm_column-left-list__link  
                    {if ($smarty.request.promo == $aBigListItem.id && $aBigListItem.types==1 && $smarty.request.group==$aBigListItem.id_group_br) || ($smarty.request.brand == $aBigListItem.id && $aBigListItem.types==4)}selected{/if}" 
                    id="{$aBigListItem.name}"
                    href="{$aBigListItem.href}" style="white-space: nowrap;">
                    {* if ($smarty.request.promo == $aBigListItem.id && $aBigListItem.types==1) || ($smarty.request.brand == $aBigListItem.id && $aBigListItem.types==4)}>{else}&nbsp;{/if *}
                    {$aBigListItem.name}</a></ul>       {*  новинки... распродажи... наборы... - меню - level=1 BigList=1 *}
                    {/if}
                {/foreach}
                </ul>
              </div>
              {foreach from=$BrandGroup.col item=aColItem } 
                <div class="gm_column"> 
                    {foreach from=$aColItem.list item=aListItem } 
                        <a class="gm_column-mainvid  {if  $smarty.request.vid == $aListItem.id }selected{/if}" id="{$aListItem.name}" href="{$aListItem.href}">{$aListItem.name}</a>    {*  Женская парфюмерия - меню - level=1  BigList=0*}
                        {if $aListItem.sublist}<ul class="gm_column-childvid">{/if}
                            {foreach from=$aListItem.sublist item=aSubListItem }
                                <ul class="gm_column-childvid__item"><a class="gm_column-childvid__link  {if  $smarty.request.vid == $aSubListItem.id}selected{/if}" id="{$aSubListItem.name}" href="{$aSubListItem.href}">{$aSubListItem.name}</a></ul> 
                            {/foreach}
                        {if $aListItem.sublist}</ul>{/if}
                    {/foreach}
                </div>
              {/foreach}
             </div>
            </div>
            {* Меню с видами*}
        </li>
    {/if}
    {/foreach} 
    </ul>
    </div>
</nav>
{literal}
  <script src="/js/chosen.jquery.js?1" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    var config = {
      '.chosen-select'           : {no_results_text:'Не найдено'},
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $('.chosen-select').on('change', function(evt, params) {
        //do_something(evt, params);
        xajax_process_browse_url('/?action=user_change_region&id_region='+params.selected);
        return false;
    });
});
  </script>
{/literal}