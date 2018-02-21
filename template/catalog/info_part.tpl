    <link href="/css/colorbox.css" rel="stylesheet" type="text/css" />
{include file=popup.tpl}
 <div class="gm-product-view info-part">
            <div class="image-block ">
                <div class="image-block">
                <div class="big">
                <div class="line" style="">
                    <ul style="">

                        <li style="">
                            <a class="colorbox cboxElement" href="{$aPartInfo.image}">
                                <img src="{$aPartInfo.image}" alt="{$aPartInfo.short_name}"></a>
                        </li>
                        <li style="">
                            <a class="colorbox cboxElement" href="{$aPartInfo.img}">
                                <img src="{$aPartInfo.img}" alt="{$aPartInfo.short_name}"></a>
                        </li>
                        <li style="">
                            <a class="colorbox cboxElement" href="{$aPartInfo.img2}">
                                <img src="{$aPartInfo.img2}" alt="{$aPartInfo.short_name}"></a>
                        </li>
                    </ul>
                </div></div>


                <div class="control">
                    <a class="colorbox cboxElement" href="{$aPartInfo.image}">
                        <span>
                            <img src="{$aPartInfo.image}" ></span>
                    </a>
                    <a class="colorbox cboxElement" href="{$aPartInfo.img}">
                        <span>
                            <img src="{$aPartInfo.img}" >
                        </span>
                    </a>
                    <a class="colorbox cboxElement" href="{$aPartInfo.img2}">
                        <span>
                            <img src="{$aPartInfo.img2}" >
                        </span>
                    </a>
                </div>                  
                <br>
                </div>
               
            </div>
            <script>$(".colorbox").colorbox({ldelim}rel:'colorbox',maxWidth:'80%'{rdelim});</script>
         
    <script src="/js/jquery.colorbox-min.js" type="text/javascript"></script>
	<!-- увелич картинка -->
	
            <div class="block-info">
             	<div class="rating-block">
                                       {* include file="catalog/stars.tpl" *}
                                       {*<noindex>
	                                       <a onclick="xajax_process_browse_url('/?action=catalog_review_edit&data[ref]={$sRef}');$('.js-add-comment-form').slideToggle(150);return false;"
	                                       rel="nofollow" class="add-comment" href="#">{$oLanguage->getMessage("add review")}</a>
                                  	   </noindex>*}
                    </div>
                    <div class="tgp-rating-sub">
						<span style="width: {$aRow.rating_star}%"></span>
					</div>
                <div class="name">{$aPartInfo.name}</div>
                <div class="code">({$oLanguage->getMessage("Code_product")}: {$aPartInfo.id})</div>
                {*<div class="code">({$oLanguage->getMessage("barcode")}: {$aPartInfo.barcode})</div>
                <div class="code">({$oLanguage->getMessage("articul")}: {$aPartInfo.art})</div>*}
                {*<div class="avail">Есть в наличии</div>*}
                <div class="clear"></div>
                <div class="name">{$aProductParent.short_name}</div>

                <div class="buy-wrap">
				
               <div class="label nocolor" style="padding-left:0;">
							 {foreach from=$aPartInfo.promo item=aItemP}
								{if $aItemP.i==33}<br>{/if}
								<span href="/?action=promo&promo_id={$aItemP.ch_id}" onmousedown="OnPromoClick('promo_{$aItemP.ch_id}'); return false;" id="promo_{$aItemP.id_product}_{$aItemP.i}" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: {$aItemP.color};">{$aItemP.name}</span>
							 {/foreach}
			   </div>
					
                    <div class="wrap-favorite">
                        <a href="javascript:void(0);" id='fav_{$aPartInfo.id}' class="link-favorite {if $aPartInfo.is_fav}active{/if}"></a>
                    </div>

                    <form method="post" onsubmit="Cart.addToCart(this); return false;" {*action="/cart/add/316"*} >
                    <div class="price">
				    {if $aPartInfo.promo.0.skidka!=0}
						<a id="price_old_{$aPartInfo.id_product}" style="text-decoration: line-through;font-size: 24px;">{$oCurrency->PrintPrice($aPartInfo.price)}</a>
						{else}
						<a> </a>
					{/if}
                        <strong>
				   <span id="price_{$aPartInfo.id_product}"  
				   {if $aPartInfo.promo.0.skidka!=0} style ="color:#ba0000;" {/if}>{if $aPartInfo.promo.0.skidka==0}{$oCurrency->PrintPrice($aPartInfo.price)} {else} {if $aPartInfo.promo.0.id_type_skidka==3} {$oCurrency->PrintPrice($aPartInfo.base_price*$aPartInfo.promo.0.skidka)}{else}{$oCurrency->PrintPrice($aPartInfo.price*$aPartInfo.promo.0.skidka)}  {/if}{/if}</span>
                            {* $oCurrency->PrintPrice($aPartInfo.price) *}
                        </strong>
                    </div>
                   
                         <div class="options">
                          {*<span class="name">{$oLanguage->getMessage("on_the_store")}: {$aPartInfo.stock} &nbsp;</span>
                            <select  class="js-uniform" id="menu_select" onchange="document.location=this.options[this.selectedIndex].value; sLoc=this.selectedIndex;" onclick="menuSelect();">
                            {foreach from=$aProductAssigned item=item}
                                 <option {if $smarty.request.product==$item.id}selected{/if} value="/?action=catalog_product&group={$item.id_brand_group}&product={$item.id}">{$item.short_name}</option>
                            {/foreach}
                            </select>*}
                         </div>       
	                        
                  
                        
                        <div data-role="buy" class="item-prices" style="display: block;">

                            <div style="text-align: center;"> 
                               <input type='hidden' name='r[{$aPartInfo.id}]' id='id_product_{$aPartInfo.id}' value=''>
								<span id='add_link_{$aPartInfo.id}'>
					{assign var=aRow value=$aPartInfo}
                    <input type=text name ="n[{$aPartInfo.id}]" id='number_{$aPartInfo.id}' style="width:90px;" value="{if $aPartInfo.request_number}{$aPartInfo.request_number}{else}1{/if}">

     
<span  id='add_link_{$aPartInfo.id}'>
{if $aPartInfo.stock>=$aRow.min_stock}
<a href="javascript:;"
onclick="{strip}
xajax_process_browse_url('/?action=cart_add_cart_item&xajax_request=1
&id_product={$aPartInfo.id}
&link_id=add_link_{$aPartInfo.id}
&number='+document.getElementById('number_{$aPartInfo.id}').value);
oCart.AnimateAdd(this);
$('#qiuck_buy_popup').fadeIn(1);
$('#qiuck_buy_popup1').fadeIn(1);
$('#qiuck_buy_popup2').fadeIn(1);
return false;{/strip}">
{/if}
<button type="submit" class="btn btn-sm btn-primary {if $aPartInfo.stock<$aRow.min_stock }missing{/if}">
{if $aPartInfo.stock<$aRow.min_stock }{$oLanguage->getMessage("isnot_store")}
{else}{$oLanguage->getMessage("buy")}

{/if}
</button>
</a>
</span>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
     {literal}
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div style="    width: 200px;
    margin-left: 51%;" data-mobile-view="true" data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1741082" data-mode="share" data-background-color="#ffffff" data-share-shape="round-rectangle" data-share-counter-size="12" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.ok.wh.vb.tm." data-text-color="#000000" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-type="disable" data-orientation="horizontal" data-following-enable="false" data-sn-ids="fb.vk.tm.ps." data-preview-mobile="false" data-selection-enable="true" data-exclude-show-more="false" data-share-style="1" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" ></div> 
                <style>
                    .horizontal{
                        margin-left: 36px !important; 
                    }
                </style>
                {/literal}
                
                
                {*<div class="product-terms formobile">
                    <div class="product-term-box ">
                        <div class="term-title"><i class="fa fa-car" aria-hidden="true"></i>
                            {$oLanguage->getMessage("Delivery")}</div>
                        {foreach from=$aDelivery item=sDelivery}
                        <div class="product-term"><div class="name">{$sDelivery.name}</div>
                            <div class="desc">
                                   {$sDelivery.description}
                            </div>
                        </div>
                        {/foreach}
                    </div>

                    <div class="product-term-box">
                        <div class="term-title"><i class="icon-hryvnya"></i>
                            {$oLanguage->getMessage("Oplata")}
                        </div>
                        {foreach from=$aOplata item=sOplata}
                        <div class="product-term">
                            <div class="name">{$sOplata.name}</div>
                                <div class="desc">{$sOplata.description}</div>
                        </div>
                        {/foreach}
                    </div>
                    <br>
            </div>*}
                
                <div class="product-terms fordesk" style="float: right;">
                    <hr>
                    <div class="product-term-box ">
{*$aDelivery|@debug_print_var*}
                        <div class="term-title"><i class="fa fa-car" aria-hidden="true"></i>
                            {$oLanguage->getMessage("Delivery")}</div>
                        {foreach from=$aDelivery item=sDelivery}
                        <div class="product-term" {if $aAuthUser.id_customer_group !='28' && $sDelivery.id == '1'} style="display:none;"{/if}><div class="name">{$sDelivery.name}</div>
                            <div class="desc">
                                   {$sDelivery.description}
                            </div>
                        </div>
                        <br>
                        {/foreach}
                    </div>

                    <div class="product-term-box">
                        <div class="term-title"><i class="fa fa-usd" aria-hidden="true"></i>
                            {$oLanguage->getMessage("Oplata")}
                        </div>
                        {foreach from=$aOplata item=sOplata}
                        <div class="product-term">
                            <div class="name">{$sOplata.name}</div>
                                <div class="desc">{$sOplata.description}</div>
                        </div>
                        <br>
                        {/foreach}
                    </div>
                    <br>
            </div>
                
             </div>

            <div class="clear"></div>

            {*<div class="js-product-description-tablet"></div>
             <div class="tgp-product-description">
                           <div class="tabs-wrapper">

		                        <div class=" tgp-comments-block">
			                        <div class="comments-form">
		                                <a class="btn js-add-comment-link" href="javascript:void(0);" onclick="xajax_process_browse_url('/?action=catalog_review_edit&data[ref]={$sRef}'); return false;">{$oLanguage->getMessage("white review")}</a>
		                                <div class="add-comments-form js-add-comment-form" id="popup_form_2">
		                                   {include file="catalog/form_review.tpl"}
		                                </div>
		                                <div class="clear"></div>
	                            	</div>
		                            <div id="review_table">
			                        	{$sReviewContent}
			                        </div>
		                        </div>
	                        </div>
	                           <div class="clear"></div>
                       </div>*}
        </div>
   
<script type="text/javascript" src="/js/cart.js"></script>  


    
   
   
   
   
   
   
   
   
   
   
   
