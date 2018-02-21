
{if $smarty.request.action == 'home' || $smarty.request.action == ''}
{include file ='home/banner_right.tpl'}
{*<div class="gm-banner-index js-banner-index">
    <div class="gm-mainer">
        <div class="wrapper">
            <div>
                <a href="#">
                    <img src="/image/_images/temp/005.jpg" alt="">
                    <img class="small" src="/image/_images/temp/006.jpg" alt="">
                </a>
            </div>
            <div>
                <a href="#">
                    <img src="/image/_images/temp/005.jpg" alt="">
                    <img class="small" src="/image/_images/temp/006.jpg" alt="">
                </a>
            </div>
            <div>
                <a href="#">
                    <img src="/image/_images/temp/005.jpg" alt="">
                    <img class="small" src="/image/_images/temp/006.jpg" alt="">
                </a>
            </div>
            <div>
                <a href="#">
                    <img src="/image/_images/temp/005.jpg" alt="">
                    <img class="small" src="/image/_images/temp/006.jpg" alt="">
                </a>
            </div>
            <div>
                <a href="#">
                    <img src="/image/_images/temp/005.jpg" alt="">
                    <img class="small" src="/image/_images/temp/006.jpg" alt="">
                </a>
            </div>
        </div>
    </div>
</div>*}

{/if}
<div class="gm-mainer" {if $aAuthUser.type_=='manager'} class="for_manager"{/if}>
    <div class="gm-block-crumbs">
    {if $aCrumbs}
            <a href="/">{$oLanguage->getMessage("main")}</a>
				            <!-- Хлебные крошки -->
				            {foreach from=$aCrumbs item=aItem name=crumb_ar}
				                {if $aItem.link}<a href="{$aItem.link}">{/if}{$aItem.name|stripslashes}{if $aItem.link}</a>{/if}
				                {if !$smarty.foreach.crumb_ar.last}&nbsp;{/if}
				            {/foreach}
						{/if}
    </div>
    {if $aPage.name && $aPage.name !=  'Головна' }
    <h1 class="page-name">{$aPage.name|capitalize|stripslashes}&nbsp;</h1>
    {else}
    {/if}
<div class="gm-block-page">

                    {if $smarty.request.action!='contact_form' && $smarty.request.action!='news' 
                        && $smarty.request.action!='user_new_account' && !$oContent->CheckDashboard($smarty.request.action) 
                        && $smarty.request.action!='cart_onepage_order' && $smarty.request.action!='cart_cart'
                        && $smarty.request.action!='cart_payment_end' && $smarty.request.action!='catalog_vid'
						&& $smarty.request.action!='catalog_promo'}
                    {$sText}
                    {*if $template.sDescription && $template.sDescription!="&nbsp;"}{$template.sDescription}{/if*}
					<hr>
					{elseif $oContent->CheckDashboard($smarty.request.action) && $smarty.request.action!='catalog_vid' && $smarty.request.action!='catalog_promo'}
					{* личный кабинет *}
					{include file=index_include/dashboard.tpl}
					{elseif $smarty.request.action == 'catalog_vid' || $smarty.request.action == 'catalog_promo'}
					{include file=index_include/dashboard_vid.tpl}
					{else}
						{$sText}
						{*if $template.sDescription && $template.sDescription!="&nbsp;"}{$template.sDescription}{/if*}
					{/if}
</div>
</div>
{if $smarty.request.brand && !$smarty.request.vid}
    {$sTextLeft}
{/if}
{if $smarty.request.action == 'home' || $smarty.request.action == '' }
{* $sTextLeft.=Base::$tpl->fetch('index_include/home_chet.tpl'); in Content.php *}

{include file='index_include/home_news.tpl'}
{$sTextLeft}

<div id="new_prop" 
	style="width: 100%; 
		height: 40px; 
        left: 0px;
		position: fixed; 
		background-color: #3f4c56;/*darkorchid; */
		bottom: 0px; 
		z-index: 900; 
		box-shadow: rgb(34, 34, 34) 0px 0px 20px 0px; 
		display: block; 
		opacity: 0.9;
        ">
<a href="/pages/news/21" style="text-decoration: none;">
  <div style="
    font-size: 1.5em;
    color: white;
    margin-left: auto;
    padding-top: 5px;
    margin-right: auto;
    width: 85%;
    text-align: center;
	cursor: pointer;">
    <span class="badge-2" data-promo=""  style="border-bottom: 1px white dashed;">Доставка по г.Чернигов БЕСПЛАТНО!
    </span>
  </div> 
</a>
</div>
{/if}