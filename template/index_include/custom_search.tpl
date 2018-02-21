          <section  class='custom_search'>
            <div class="gm-productlist-wrap">
                <div class="head">
                    <div class="block-view js-change-view">
                        <a href="{$sGroupChangeTableUrl}&table=list" class="list{if $smarty.request.table=='list'} selected{/if}" data-type="list"></a>
                        <a href="{$sGroupChangeTableUrl}&table=line" class="line{if $smarty.request.table=='line'} selected{/if}" data-type="line"></a>
                        <a href="{$sGroupChangeTableUrl}&table=thumb" class="thumb{if $smarty.request.table=='thumb'|| $smarty.request.table==''} selected{/if}" data-type="thumb"></a>
                    </div>

                    <div class="block-sort">
                        <span class="title">Сортувати:</span>
                        <select class="js-uniform" onchange="document.location=this.options[this.selectedIndex].value;">
                            <option {if $smarty.request.sort=='name'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=name{else}sort=name{/if}">{$oLanguage->GetMessage('по імені')}</option>
                            <option {if $smarty.request.way=='up'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=price&way=up{else}sort=price/way=up{/if}">{$oLanguage->GetMessage('зростанню ціни')}</option>
        					<option {if $smarty.request.way=='down'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=price&way=down{else}sort=price/way=down{/if}">{$oLanguage->GetMessage('зменшенню ціни')}</option>
{*                            <option {if $smarty.request.sort=='new'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=new{else}sort=new{/if}">{$oLanguage->GetMessage('новинки')}</option> *}
                        </select>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            {*<div class="gm-filter-values">
                <div class="filter-name">Вы выбрали:</div>
                <a href="#" class="link-selected">от 300  до 800 грн</a>
                <a href="#" class="link-selected">Украина</a>
                <a href="#" class="link-selected">От темных кругов</a>
                <a class="gm-link-dashed" href="#">Сбросить</a>
            </div> *}
{$sPriceTable}

        </section>
<div class="clear"></div>
