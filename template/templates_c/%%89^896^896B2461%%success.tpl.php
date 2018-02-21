<?php /* Smarty version 2.6.18, created on 2018-02-19 10:23:12
         compiled from index_include/success.tpl */ ?>
<?php if ($this->_tpl_vars['bSuccess_by_phone']): ?><div class="name" style="font-size:20px;font-weight:600;"><span>Вы успешно сделали заказ по телефону!</span></div><?php endif; ?>
<h2 class="line-through"><span>Дякуємо за покупку!</span></h2>
    <div class="gm-block-page gm-block-success">
        

        <div class="caption">
            Номер вашего заказа: <strong class="important"><?php echo $this->_tpl_vars['aCartPackage']['id']; ?>
</strong>
        </div>

        <div class="content">
            Уважаемый покупатель, <strong class="name"><?php echo $this->_tpl_vars['aCartPackage']['name']; ?>
</strong><br />
            <br />
  В ближайшее время мы вам перезвоним для уточнения заказа
           <br />
            <br />
            <div class="thank">
                Спасибо за покупку!
            </div>
        </div>

        <div class="gm-block-news-more">
            <span><a class="gm-link-dashed" href="/">На главную</a></span>
        </div>
    </div>