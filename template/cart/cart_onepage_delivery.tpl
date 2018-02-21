
<div class="head" id='delivery2'>{$oLanguage->getMessage("Delivery methods")}:</div>
                <div id='delivery2_2' class="block-labels js-block-label">
                {foreach from=$aDeliveryType item=aItem name=foo}
                 
                    <label    {if $aUser.customer_group_name != 'PERSONAL' && $aItem.id == 1} style="display:none;"{/if}><div class="label {if !$bAlreadySelectedDelivery}selected{/if}">
                        <input type="radio" style="-webkit-appearance: radio;" name="id_delivery_type"
                        value="{$aItem.id}"
            
            {if $aItem.description } onclick="{strip}show_delivery_description('delivery_description_{$aItem.id}');xajax_process_browse_url('?action=delivery_set&xajax_request=1&id_delivery_type={$aItem.id}');{/strip}" {/if}
            {if !$bAlreadySelectedDelivery}
                {assign var=bAlreadySelectedDelivery value=1}
                checked
            {/if}>
                        <span class="caption">{$aItem.name}</span>
                    </div></label>
                    <div {if $aUser.customer_group_name != 'PERSONAL' && $aItem.id == 1} style="display:none;"{/if} class="delivery_description delivery_description_{$aItem.id} del_{$aItem.code}" 
{if $smarty.foreach.foo.first}style="display:block;"{else}
                    style="display:none;"{/if}>
                        {$aItem.description}
                    </div>
                     
                {/foreach}
<br>
 {*$oLanguage->getText("viddilenny")*}
                 {*<span id="gone" style="display:none;">
                    <div id="np-map" style="display:inline-block;"><span style="line-height: 30px;"><button id="npw-map-open-button" type="button">НАЙБЛИЖЧЕ ВІДДІЛЕННЯ</button><script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPhm7Q29X5ldwjLtA7IMYHU_0xATiWK3A"></script></span></div>
<input type=text class="novaposta" name="novaposta" value="" readonly>
                 </span>*}
                
               <span id="gone2" style="display:none;">
                
                <br>
                 <input type=hidden class="novaposta" id="novaposta" name="novaposta" value="">
{*<div id="np-calc-body" class="np-w-br-0" style="width: 200px; min-height: 322px; margin: 0;"> <div class="np-calc-wrapper"> <div class="np-calc-logotype"></div> <div class="np-hl"></div> <span id="np-calc-title">Розрахунок вартості<br>доставки</span> <div class="np-calc-list"> <div class="np-calc-field" name="dispatch" role="CitySender"> <input type="text" class="np-option-search-item" placeholder="Звідки"> <div class="np-toggle-options-list"></div> <ul class="np-options-enter-point" role="CitySender"></ul> </div> <div id="np-arrows" name=""></div> <div class="np-calc-field" name="catch" role="CityRecipient"> <input type="text" class="np-option-search-item" placeholder="Куди"> <div class="np-toggle-options-list"></div> <ul class="np-options-enter-point" role="CityRecipient"></ul> </div> <div class="np-calc-field" name="weight" role="Weight"> <input type="text" class="np-option-search-item-weight" placeholder="Вага посилки"> </div> </div> <div class="np-line-background"></div> <button id="np-calc-submit" type="button"> <span id="np-text-button">Розрахувати</span> <div id="np-load-image"></div> </button> </div> <div id="np-cost-field"> <div class="np-cost-field-container"> <p id="np-cost-number"></p> <span>грн</span> </div> <div class="np-cost-info-container"> <span>Вартість доставки</span><br> <div id="np-current-city"></div> <span>вагою </span> <span id="np-current-weight"></span> <span>кг</span> </div> <div class="np-mini-logo"> <div class="np-line-left"></div> <div class="np-line-right"></div> </div> <a href="https://novaposhta.ua/delivery?utm_source=calc&amp;utm_medium=widget&amp;utm_term=calc&amp;utm_content=widget&amp;utm_campaign=NP" target="_blank"> Детальний розрахунок </a> <button type="button" id="np-cost-return-button">Інша посилка</button> </div> <div id="np-error-field"> <div class="np-status-logo"> <img src="https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/img/not-found.svg" alt="error icon"> </div> <div class="np-error-info-container"> <span>Вибачте! З технічних причин ми не змогли розрахувати Вартість посилки</span> </div> <div class="np-mini-logo"> <div class="np-line-left"></div> <div class="np-line-right"></div> </div> <button type="button" id="np-error-return-button">Інша посилка</button> </div> </div>{$oLanguage->getText("inform_NovaPosta")*}
             </span>
                </div>

                {literal}<script type="text/javascript">
function show_delivery_description(id_show) {
    $('div.delivery_description').hide();
    $('.'+id_show).show();
    if ($('.del_NovaPoshta').is(':visible')){
        $('span#gone').css('display','inline-block');
        $('.'+id_show).css('display','inline-block');
        $('span#gone2').css('display','block');
        $('#for_np').css('display','none');
    }
    else{
       $('span#gone').css('display','none');
       $('span#gone2').css('display','none'); 
       $('#for_np').css('display','block');
    }
     if ($('.del_kurer').is(':visible')){
        $('.nova').css('display','none');
    }
}
$(function(){
        $('#npw-map-sidebar-ul').on('click', 'li', function(){
      var viddil = $(this).find('.npw-list-warehouse').html()
      event.preventDefault();
       $( ".novaposta" ).val( viddil );
    });  
  
});
</script>
<style>
    #npw-map-wrapper{
    top: 3% !important;
    left: 30% !important;
    position: fixed !important;
    }

    @media (max-width: 800px){
#npw-map-wrapper{
width: 294px;
    top: 3% !important;
    left: 5% !important;
}

#npw-map-sidebar {
    height: 100% !important;
    width: 50% !important;
    float: left !important;
}

#npw-map {
    height: 100% !important;
    width: 49% !important;
    float: left !important;
}
#step_2_3{
    margin:0 !important;
}
}

</style>
{/literal}

{literal}<script type='text/javascript' src='https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Map/dist/map.min.js'></script>
<script type='text/javascript' src='https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Calc/dist/calc.min.js'></script>{/literal}