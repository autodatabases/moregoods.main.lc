

<footer class="gm-block-footer">
    <div class="gm-mainer">
        <div class="block-logo">
            <a href="/"><img src="/image/_images/success-bg-bird.jpg" alt="" width="80px" height="80px"></a>
            <span class="date">{$oLanguage->GetMessage('copyright')} - {$smarty.now|date_format:"%Y"}</span>
        </div>

        <div class="block-phones">
        {*$sPhone1*}
        {$sPhone2}
            {*$oLanguage->GetConstant('global:project_phone')*}
        </div>

        {$oLanguage->GetText('bottom_links1_2')}

        {*<div class="block-social">
            <a href="{$oLanguage->GetText('bottom_facebook')}" class="fb"><i class="fa fa-facebook-square" aria-hidden="true" style="font-size:40px;"></i></a>
            <a href="{$oLanguage->GetText('bottom_vk')}" class="vk"><i class="fa fa-vk" aria-hidden="true" style="font-size:40px;"></i></a>
        </div>*}

        {*<div class="block-madeby">
            <a href="#" class="irbis"></a>
            Дизайн <a href="http://www.stylepix.net">www.stylepix.net</a>
        </div>*}

        <div class="block-year">&copy; 2017</div>
        <div class="clear"></div>
        
        <div class="footer-description">{*if $template.sDescription && $template.sDescription!="&nbsp;"}{$template.sDescription}{/if*}</div>
    </div>
</footer>

<div class="gm-block-left-curtain close js-block-left-curtain">
    <div class="head">
        <div class="close js-block-left-curtain-toggle"></div>
        {if $aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login)) }
        <a class="enter already" href='/pages/dashboard'>Мой кабинет</a>
        {else}
        <a class="enter already" href="javascript:void(0);" onclick="popupOpen('.js-popup-auth');">Войти</a>
        {/if}
    </div>
    <ul class="body">
{foreach from=$EcBrandGroup item=BrandGroup key=id}
			<li>
				{*  Меню с брендами *}
                {if $BrandGroup.sub}
                <a class="toggle" href="/?action=catalog_vid&group={$id}" onclick="document.location='/?action=catalog_vid&group={$id}'">{$BrandGroup.name}</a>
                <ul>
		    {if $OLD_Interface}
                {foreach from=$BrandGroup.sub item=Item key=id2}
                    <li><a href="/?action=catalog_brand&group={$id}&brand={$Item.id_brand}">{$Item.brand}</a></li>
                {/foreach}
       	    {else}
			{*  меню с акциями и брендами *}
				{foreach from=$BrandGroup.biglist item=aBigListItem }
				  {if $aBigListItem}
					{if $aBigListItem.types!=4  && $aBigListItem.types!=2 || ($smarty.request.brand == $aBigListItem.id && $aBigListItem.types==4)}
					<li><a class="gm_column-left-list__link
					{if ($smarty.request.promo == $aBigListItem.id && $aBigListItem.types==1 && $smarty.request.group==$aBigListItem.id_group_br) || ($smarty.request.brand == $aBigListItem.id && $aBigListItem.types==4)}selected{/if}" 
					" style="color: #5fb7c1;" href="{$aBigListItem.href}"style="white-space: nowrap;">{$aBigListItem.name}</a> </li>
					{/if}
				  {/if}
				{/foreach}
				<br>
			{* Меню с видами*}
			  {foreach from=$BrandGroup.col item=aColItem } 
					{foreach from=$aColItem.list item=aListItem } 
						<li><a class="gm_column-mainvid {if  $smarty.request.vid == $aListItem.id }selected{/if}" style="color: #5fb7c1;" href="{$aListItem.href}">{$aListItem.name}</a>	</li>
							{foreach from=$aListItem.sublist item=aSubListItem }
								<li><a class="gm_column-childvid__link {if  $smarty.request.vid == $aSubListItem.id}selected{/if}" style="color: #afbcc1;" href="{$aSubListItem.href}">&nbsp;&nbsp;{$aSubListItem.name}</a> </li>
							{/foreach}
					{/foreach}
		      {/foreach}
			{* Меню с видами*}
			{/if}

                <li><a class="show_all" href="/?action=catalog_vid&group={$id}">{$oLanguage->getMessage('Show all')}</a></li>
                </ul>
                {else}
                <a href="/?action=catalog_group&group={$id}">{$BrandGroup.name}</a>
                {/if}
            </li>
            
         {/foreach} 
          
    </ul>
</div>

