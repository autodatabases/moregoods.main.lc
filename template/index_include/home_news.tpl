{if $aNews}<div class="gm-mainer">
    {*<h2 class="line-through"><span>{$oLanguage->GetMessage('news_and_action')}</span></h2>*}

    <ul class="gm-block-news preview">
    {foreach from=$aNews item=aItem}
        <li class="news-element">
            <div class="image"><a href="/pages/news/{$aItem.id}"><img src="{$aItem.image}" alt="" style="max-width: 180px;max-height:180px"></a></div>
            <div class="date">{$oLanguage->GetPostDate($aItem.post_date)}</div>
           {if $aItem.page_description} <div class="name"><a href="/pages/news/{$aItem.id}">{$aItem.page_description}</a></div>{/if}
            <div class="description">{$aItem.short}</div>
            </li>
         {/foreach}   
        <li class="news-empty"></li>
        <li class="news-empty"></li>
        <li class="news-empty"></li>
    </ul>
    <div class="gm-block-news-more">
        <span><a class="gm-link-dashed" href="/pages/news">{$oLanguage->GetMessage('all_news_and_action')}</a></span>
    </div>
</div>{/if}