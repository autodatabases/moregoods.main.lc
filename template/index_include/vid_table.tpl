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
<div class="clear"></div>