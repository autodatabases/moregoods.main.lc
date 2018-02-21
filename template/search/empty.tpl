<div class="gm-block-page gm-block-404 no-results">
        <div class="wrapper">
            <div class="caption">
                По запросу "{if $smarty.request.search.query}{$smarty.request.search.query}{else}{$smarty.request.code}{/if}"<br />
                <span class="important">Нет результатов</span>
            </div>

            Попробуйте изменить запрос или обратитесь к нашим консультантам за помощью!

			<form action="/" >
            <div class="block-search">
                <input type="text" name="code" value="{$smarty.get.code}" placeholder="Поиск по товарам">
                <input type="submit" value="">
                <input name="action" value="catalog_price_view" type="hidden">
            </div>
            </form>

            <div class="block-contacts">
                <span class="phone">(044) 473-74-37</span><br />
                <a class="email" href="mailto:feofan@mg.com.ua">feofan@mg.com.ua</a><br />
            </div>
        </div>
    </div>