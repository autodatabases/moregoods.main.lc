{if $bSuccess_by_phone}<div class="name" style="font-size:20px;font-weight:600;"><span>Вы успешно сделали заказ по телефону!</span></div>{/if}
{*<h1 class="page-name">Замовлення успішно відправлено</h1>*}
<h2 class="line-through"><span>Спасибо за покупку!</span></h2>
    <div class="gm-block-page gm-block-success">
        

        <div class="caption">
            Номер вашего заказа: <strong class="important">{$aCartPackage.id}</strong>
        </div>

        <div class="content">
            Уважаемый покупатель, <strong class="name">{$aCartPackage.name}</strong><br />
            <br />
{*            Найближчим часом наш менеджер зв`яжеться з Вами по телефону для підтвердження наявності товару та уточнення дати, часу та адреси доставки.<br />
            <br />
            По всім питанням звертайтесь за телефонами:<br />
            {$oLanguage->GetConstant('global:project_phone')}
            <br />
  *}
  В ближайшее время мы вам перезвоним для уточнения заказа
           {* Найближчим часом Ви отримаєте лист з інформацією по Вашому замовленню, а також смс підтвердження  *}<br />
            <br />
            <div class="thank">
                Спасибо за покупку!
            </div>
        </div>

        <div class="gm-block-news-more">
            <span><a class="gm-link-dashed" href="/">На главную</a></span>
        </div>
    </div>