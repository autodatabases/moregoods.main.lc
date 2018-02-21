                           <form name="review_form2" action="/">

                            <div id ="review_message">
                            </div>
                           	
                               <div class="add-name-field">
                                   <span class="descript-field">{$oLanguage->getMessage("Your name")}</span><br/>                             
                                   {if $aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login)) }{$aAuthUser.name}
   		<input id=review_name type="hidden" name=data[name] value="{$aAuthUser.name}">{else}
   		<input id=review_name type="text" name=data[name] value="{$smarty.request.data.name}" style='width:100%;'>
   		{/if}
                               </div>
                               <div class="add-name-field" style="padding-left:20px;">
                                   <span class="descript-field">{$oLanguage->getMessage("Your email")}</span>
                                   {if $aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login)) }<br/>{else}
                                   <a class="enter-link" href="/pages/user_login/">{$oLanguage->getMessage("Enter_by_your_own_name")}</a><br/> 
                                   {/if}                            
		{if !$aAuthUser.email}
		<input id=review_email type="text" name=data[email] value="{$smarty.request.data.email}" style='width:100%;'>
		{else}{$aAuthUser.email}
		<input id=review_email type="hidden" name=data[email] value="{$aAuthUser.email}">
		{/if}
		<input type=hidden name="data[ref]" value="{$sRef}">
		<input type=hidden name="is_post" value="1">
		<input type=hidden name="action" value="catalog_review_edit">
                               </div>
                               <div class="add-rating-field" {if $aAuthUser.type_!='manager'}style="margin-left:10px;"{/if}>
                                   <span class="descript-field">{$oLanguage->getMessage("product evaluation")}</span><br />
                                   <div id="rating-new" class="tgp-rating-big" onclick="xajax_process_browse_url('/?action=catalog_stars&item_code={$sRef}'); ShowPopup('100px');return false;">
                                       <span style="width: {$iStar}%"></span>
                                   </div>
                                   <span class="mark" id="rating-text">{$oLanguage->getMessage("super")}</span>
                               </div>
                               <a onclick="$('.js-add-comment-form').slideToggle(150);" style="position:absolute; right:0; top:0; cursor:pointer;"><img src="/image/close.png"></a>
                               <div class="add-comment-field">
                                   <span class="descript-field">{$oLanguage->getMessage("your_rewiew")}</span><br />
                                   <textarea id="review_text" name="data[text]"></textarea>
                               </div>
                               <div class="foot-field" >
                               {if $aData.id}<input type=hidden name="data[id]" value="{$aData.id}">{/if}
	{if $aData.edit}<input type=hidden name="data[edit]" value="{$aData.edit}">{/if}
                                   <span class="descript-field">{$oLanguage->getMessage("inputtext from img")}</span>
                                   <span id="review_capcha">{$sCapcha}</span>
                                   {if $aAuthUser.type_=='manager'}
                                   	<input class="tgp-button-grey" type="submit" value="Опубликовать" />
                                   {else}
                                    <a class="tgp-button-grey" {literal}
                                    onclick="var elems = document.review_form2.getElementsByTagName('*'); var url='/?action=catalog_review_edit';
			for (var i = 0; i < elems.length; i++){if (elems[i].name) url=url+'&'+elems[i].name+'='+encodeURI(elems[i].value)};
			xajax_process_browse_url(url);return false;"{/literal}> Опубликовать </a>
		{/if}
                                   <div class="clear"></div>
                               </div>
                           </form>