<aside class="gm-aside-left">
            <nav class="gm-portal-menu">
                <ul {if $sIdTable!=""}id="{$sIdTable}"{/if}>
                
{assign var="iTr" value="0"}
{section name=d loop=$aItem}
{assign var=aRow value=$aItem[d]}
{assign var=iTr value=$iTr+1}

{include file=$sDataTemplate}

{/section}
                </ul>
            </nav>
        </aside>
        <section class="gm-section-content">
	        <div class="gm-banner-index portal js-banner-index">
	           <div class="mainer">
	              <div class="wrapper">
						{foreach from=$aBannerVid item=aSingleBannerVid}
						<div><a href="{$aSingleBannerVid.link}">
						<img src="{$aSingleBannerVid.image}"
							alt="{$aSingleBannerVid.name}" style="width:907px; height: 339px;"/>
							<img class="small" src="{$aSingleBannerVid.image}" alt="">
							</a>
						</div>
						{/foreach}
				  </div>  
	          </div>
	        </div>
        </section>
<div class="clear"></div>