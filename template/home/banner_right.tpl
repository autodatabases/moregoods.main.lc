<div class="gm-banner-index js-banner-index">
<div class="gm-mainer">
<div class="wrapper">
{foreach from=$aBanner item=aSingleBanner}
{if $aSingleBanner.is_main}
<div><a href="{$aSingleBanner.link}">
<img src="{$aSingleBanner.image}"
	alt="{$aSingleBanner.name}" style="width:1140px; height: 200px;"/>
	<img class="small" src="{$aSingleBanner.image_small}" alt="">
	</a>
</div>{/if}
{/foreach}
</div>
</div>
</div>


