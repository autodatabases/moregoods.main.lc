<?php /* Smarty version 2.6.18, created on 2017-05-15 18:46:18
         compiled from catalog/form_review.tpl */ ?>
                           <form name="review_form2" action="/">

                            <div id ="review_message">
                            </div>
                           	
                               <div class="add-name-field">
                                   <span class="descript-field"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Your name'); ?>
</span><br/>                             
                                   <?php if ($this->_tpl_vars['aAuthUser']['id'] && ! ( $this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aAuthUser']['login']) )): ?><?php echo $this->_tpl_vars['aAuthUser']['name']; ?>

   		<input id=review_name type="hidden" name=data[name] value="<?php echo $this->_tpl_vars['aAuthUser']['name']; ?>
"><?php else: ?>
   		<input id=review_name type="text" name=data[name] value="<?php echo $_REQUEST['data']['name']; ?>
" style='width:100%;'>
   		<?php endif; ?>
                               </div>
                               <div class="add-name-field" style="padding-left:20px;">
                                   <span class="descript-field"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Your email'); ?>
</span>
                                   <?php if ($this->_tpl_vars['aAuthUser']['id'] && ! ( $this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aAuthUser']['login']) )): ?><br/><?php else: ?>
                                   <a class="enter-link" href="/pages/user_login/"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Enter_by_your_own_name'); ?>
</a><br/> 
                                   <?php endif; ?>                            
		<?php if (! $this->_tpl_vars['aAuthUser']['email']): ?>
		<input id=review_email type="text" name=data[email] value="<?php echo $_REQUEST['data']['email']; ?>
" style='width:100%;'>
		<?php else: ?><?php echo $this->_tpl_vars['aAuthUser']['email']; ?>

		<input id=review_email type="hidden" name=data[email] value="<?php echo $this->_tpl_vars['aAuthUser']['email']; ?>
">
		<?php endif; ?>
		<input type=hidden name="data[ref]" value="<?php echo $this->_tpl_vars['sRef']; ?>
">
		<input type=hidden name="is_post" value="1">
		<input type=hidden name="action" value="catalog_review_edit">
                               </div>
                               <div class="add-rating-field" <?php if ($this->_tpl_vars['aAuthUser']['type_'] != 'manager'): ?>style="margin-left:10px;"<?php endif; ?>>
                                   <span class="descript-field"><?php echo $this->_tpl_vars['oLanguage']->getMessage('product evaluation'); ?>
</span><br />
                                   <div id="rating-new" class="tgp-rating-big" onclick="xajax_process_browse_url('/?action=catalog_stars&item_code=<?php echo $this->_tpl_vars['sRef']; ?>
'); ShowPopup('100px');return false;">
                                       <span style="width: <?php echo $this->_tpl_vars['iStar']; ?>
%"></span>
                                   </div>
                                   <span class="mark" id="rating-text"><?php echo $this->_tpl_vars['oLanguage']->getMessage('super'); ?>
</span>
                               </div>
                               <a onclick="$('.js-add-comment-form').slideToggle(150);" style="position:absolute; right:0; top:0; cursor:pointer;"><img src="/image/close.png"></a>
                               <div class="add-comment-field">
                                   <span class="descript-field"><?php echo $this->_tpl_vars['oLanguage']->getMessage('your_rewiew'); ?>
</span><br />
                                   <textarea id="review_text" name="data[text]"></textarea>
                               </div>
                               <div class="foot-field" >
                               <?php if ($this->_tpl_vars['aData']['id']): ?><input type=hidden name="data[id]" value="<?php echo $this->_tpl_vars['aData']['id']; ?>
"><?php endif; ?>
	<?php if ($this->_tpl_vars['aData']['edit']): ?><input type=hidden name="data[edit]" value="<?php echo $this->_tpl_vars['aData']['edit']; ?>
"><?php endif; ?>
                                   <span class="descript-field"><?php echo $this->_tpl_vars['oLanguage']->getMessage('inputtext from img'); ?>
</span>
                                   <span id="review_capcha"><?php echo $this->_tpl_vars['sCapcha']; ?>
</span>
                                   <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
                                   	<input class="tgp-button-grey" type="submit" value="Опубликовать" />
                                   <?php else: ?>
                                    <a class="tgp-button-grey" <?php echo '
                                    onclick="var elems = document.review_form2.getElementsByTagName(\'*\'); var url=\'/?action=catalog_review_edit\';
			for (var i = 0; i < elems.length; i++){if (elems[i].name) url=url+\'&\'+elems[i].name+\'=\'+encodeURI(elems[i].value)};
			xajax_process_browse_url(url);return false;"'; ?>
> Опубликовать </a>
		<?php endif; ?>
                                   <div class="clear"></div>
                               </div>
                           </form>