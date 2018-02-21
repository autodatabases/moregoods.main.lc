<div class="news-block">
	<div class="caption caption-green">Новости</div>
    <div class="block-news">
    {foreach from=$aNews item=aItem}
    	<div class="item">
        	<span>{$oLanguage->GetPostDate($aItem.post_date)}</span><br />
            <a href="/?action=news_preview&id={$aItem.id}">{$aItem.short}</a>
        </div>
    {/foreach}
        <a href='/?action=news' class="archive">{$oLanguage->GetMessage('other news...')}</a>
    </div>
</div>