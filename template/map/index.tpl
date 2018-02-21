{foreach from=$aMap item=aItem}
<div style="padding-left: {math equation="x * y" x=10 y=$aItem.level}px;">

{if $aItem.level==1}
<img src='/image/plus3.gif' hspace=2 align=absmiddle>
{else}
&nbsp;&nbsp;<img src='/image/plus1.gif' hspace=2 align=absmiddle>
{/if}

        <a href='{if !$aItem.link}?action={$aItem.code}{else}{$aItem.code}{/if}'
                >{$aItem.name}</a> {if $aItem.page_description}- {$aItem.page_description}{/if}
</div>

{/foreach}