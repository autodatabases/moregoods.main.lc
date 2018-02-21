{if $aRow.name && !$aRow.child}
<li>
    <a class="without-sub" id="{$aPage.name}=>{$aRow.name}" href="/?action=catalog_vid&group={$aRow.id_brand_group}&brand={$aRow.id_brand}{if !$aRow.id==0}&vid={$aRow.id}{/if}"><span>{$aRow.name|stripslashes}</span></a>
</li>
{elseif $aRow.name && $aRow.child}
<li class="with-sub" id="{$aPage.name}=>{$aRow.name}"><a><span>{$aRow.name|stripslashes}</span></a>
{/if}
{if $aRow.child}
<ul>
{foreach from=$aRow.child item=aChild}
<li><a class="with-child" id="{$aPage.name}=>{$aRow.name}=>{$aChild.name}" href="/?action=catalog_vid&group={$aChild.id_brand_group}&brand={$aChild.id_brand}&vid={$aChild.id}">{$aChild.name|stripslashes}</a>
</li>
{/foreach}
</ul></li>{/if}