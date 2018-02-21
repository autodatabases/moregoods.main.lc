<?php /* Smarty version 2.6.18, created on 2018-01-13 17:42:23
         compiled from search/empty.tpl */ ?>
<div class="gm-block-page gm-block-404 no-results">
        <div class="wrapper">
            <div class="caption">
                По запросу "<?php if ($_REQUEST['search']['query']): ?><?php echo $_REQUEST['search']['query']; ?>
<?php else: ?><?php echo $_REQUEST['code']; ?>
<?php endif; ?>"<br />
                <span class="important">Нет результатов</span>
            </div>

            Попробуйте изменить запрос или обратитесь к нашим консультантам за помощью!

			<form action="/" >
            <div class="block-search">
                <input type="text" name="code" value="<?php echo $_GET['code']; ?>
" placeholder="Поиск по товарам">
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