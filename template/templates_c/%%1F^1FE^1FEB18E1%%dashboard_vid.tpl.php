<?php /* Smarty version 2.6.18, created on 2018-02-15 12:21:39
         compiled from index_include/dashboard_vid.tpl */ ?>
        <!--<aside class="gm-aside-left">
            <div class="gm-block-filter close js-block-left-filter">
                <div class="head">
                    <div class="close js-block-left-filter-toggle"></div>
                    <?php echo $this->_tpl_vars['oLanguage']->getMessage('to_filter'); ?>

                </div>
                <div class="body">
              
   <div class="filter-element">
   <div class="filter-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('you_choose'); ?>
:</div>
			<?php if ($_REQUEST['promo']): ?>
					<?php if ($this->_tpl_vars['aPage']['promo']): ?><a id="<?php echo $this->_tpl_vars['aPage']['promo']; ?>
" href="<?php echo $this->_tpl_vars['sUrl']; ?>
&remove_promo=<?php echo $_REQUEST['promo']; ?>
" class="link-selected remove-filter-poromo" style="white-space: nowrap";><?php echo $this->_tpl_vars['aPage']['promo']; ?>
</a><?php endif; ?>
					<br>
			<?php endif; ?>		
			<?php if ($_REQUEST['brand']): ?>
					<?php if ($this->_tpl_vars['aPage']['brand']): ?><a id="<?php echo $this->_tpl_vars['aPage']['brand']; ?>
" href="<?php echo $this->_tpl_vars['sUrl']; ?>
&remove_brand=<?php echo $_REQUEST['brand']; ?>
" class="link-selected remove-filter-brand" style="white-space: nowrap";><?php echo $this->_tpl_vars['aPage']['brand']; ?>
</a><?php endif; ?>
			<?php endif; ?>		
		<div class="link-clear">
			<a class="clear-filter"  
        <?php if ($_REQUEST['promo']): ?> href="/?action=catalog_vid&<?php if ($_REQUEST['group']): ?>group=<?php echo $_REQUEST['group']; ?>
<?php endif; ?>"
        <?php else: ?>
            href="<?php echo $this->_tpl_vars['sUrl']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>&remove_all=1" 
        <?php endif; ?>
        class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('clear_filter'); ?>
</a><br />
   		</div>
			<?php if ($_REQUEST['vid']): ?>
				<?php $_from = $this->_tpl_vars['aTmpChooseBra']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aChooseBra']):
?>
					<a id="<?php echo $this->_tpl_vars['aChooseBra']['name']; ?>
" href="<?php echo $this->_tpl_vars['sUrl']; ?>
&remove=vid&value=<?php echo $this->_tpl_vars['aChooseBra']['id']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>" class="link-selected remove-filter-vid"><?php echo $this->_tpl_vars['aChooseBra']['name']; ?>
</a><br />
				<?php endforeach; endif; unset($_from); ?>
    		
			<?php endif; ?>
		
    <?php if ($_REQUEST['choose']): ?>
    	<?php $_from = $this->_tpl_vars['aTmpChoose']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aChoose']):
?>
    		<a id="<?php echo $this->_tpl_vars['aChoose']['anval_nm']; ?>
" href="<?php echo $this->_tpl_vars['sUrl']; ?>
&remove=choose&value=<?php echo $this->_tpl_vars['aChoose']['id']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>" class="link-selected remove-filter-atrib"><?php echo $this->_tpl_vars['aChoose']['anval_nm']; ?>
</a><br />
    	<?php endforeach; endif; unset($_from); ?>
    	<?php endif; ?>
		
   	</div>
        <div class="filter-element">
             <label><input class="filter-vid-checkbox" id="" type="checkbox" <?php if ($_REQUEST['promo']): ?> checked <?php endif; ?>
              onclick="document.location='/?action=catalog_promo&<?php if ($_REQUEST['group']): ?>group=<?php echo $_REQUEST['group']; ?>
<?php endif; ?>&promo=3<?php if ($_REQUEST['choose']): ?>&choose=<?php echo $_REQUEST['choose']; ?>
<?php endif; ?>'">
              <a class="filter-vid" id="" href="/?action=catalog_promo&<?php if ($_REQUEST['group']): ?>group=<?php echo $_REQUEST['group']; ?>
<?php endif; ?>&promo=3<?php if ($_REQUEST['choose']): ?>&choose=<?php echo $_REQUEST['choose']; ?>
<?php endif; ?>" onclick="document.location=this.href;">Акції</a></label>
        </div>
        		<div class="filter-element">
		      <div class="filter-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('vid'); ?>
</div>
		      <?php $_from = $this->_tpl_vars['aVidsFilter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aKey'] => $this->_tpl_vars['aItem']):
?>
		      <label><input class="filter-vid-checkbox" id="<?php echo $this->_tpl_vars['aItem']['name']; ?>
" type="checkbox" <?php if ($this->_tpl_vars['aItem']['checked']): ?> checked <?php endif; ?>
		      onclick="document.location='<?php echo $this->_tpl_vars['sUrl']; ?>
&set_vid=<?php echo $this->_tpl_vars['aItem']['id_vid']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>'">
		      <a class="filter-vid" id="<?php echo $this->_tpl_vars['aItem']['name']; ?>
" href="<?php echo $this->_tpl_vars['sUrl']; ?>
&set_vid=<?php echo $this->_tpl_vars['aItem']['id_vid']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>" onclick="document.location=this.href;"><?php echo $this->_tpl_vars['aItem']['name']; ?>
</a> (<?php echo $this->_tpl_vars['aItem']['qty']; ?>
)</label>
		      <?php endforeach; endif; unset($_from); ?>
		  </div>
				<?php $_from = $this->_tpl_vars['aAtributeAll']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
		<div class="filter-element">
		      <div class="filter-name"><?php echo $this->_tpl_vars['aItem']['variable_nm']; ?>
</div>
		      <?php $_from = $this->_tpl_vars['aItem']['atrib']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aAtrib']):
?>
		      <label><input class="filter-atrib-checkbox" id="<?php echo $this->_tpl_vars['aAtrib']['anval_nm']; ?>
" type="checkbox" <?php if ($this->_tpl_vars['aAtrib']['checked']): ?> checked <?php endif; ?>
		      onclick="document.location='<?php echo $this->_tpl_vars['sUrl']; ?>
&<?php if ($this->_tpl_vars['aAtrib']['checked']): ?>remove<?php else: ?>add<?php endif; ?>=choose&value=<?php echo $this->_tpl_vars['aAtrib']['id']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>'">
		      <a class="filter-atrib-checkbox" id="<?php echo $this->_tpl_vars['aAtrib']['anval_nm']; ?>
" href="<?php echo $this->_tpl_vars['sUrl']; ?>
&<?php if ($this->_tpl_vars['aAtrib']['checked']): ?>remove<?php else: ?>add<?php endif; ?>=choose&value=<?php echo $this->_tpl_vars['aAtrib']['id']; ?>
<?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>" onclick="document.location=this.href;"><?php echo $this->_tpl_vars['aAtrib']['anval_nm']; ?>
</a> (<?php echo $this->_tpl_vars['aAtrib']['qty']; ?>
)</label>
		      <?php endforeach; endif; unset($_from); ?>
		  </div>
		<?php endforeach; endif; unset($_from); ?>
		<div class="filter-element">
                        <div class="filter-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('price'); ?>
</div>
                        <input class="from-to" id="minCost" type="text" value='<?php if ($_REQUEST['price_min']): ?><?php echo $_REQUEST['price_min']; ?>
<?php else: ?>0<?php endif; ?>' readonly> -
                        <input class="from-to" id="maxCost" type="text" value='<?php if ($_REQUEST['price_max']): ?><?php echo $_REQUEST['price_max']; ?>
<?php else: ?>2500<?php endif; ?>' readonly>

                       <input class="send" type="submit" value=""
         onclick="document.location='/?action=catalog_vid&group=<?php echo $_REQUEST['group']; ?>
<?php if ($_REQUEST['brand']): ?>&brand=<?php echo $_REQUEST['brand']; ?>
<?php endif; ?><?php if ($_REQUEST['vid']): ?>&vid=<?php echo $_REQUEST['vid']; ?>
<?php endif; ?><?php if ($_REQUEST['table']): ?>&table=<?php echo $_REQUEST['table']; ?>
<?php endif; ?>&price_min='+$('#minCost').val()+'&price_max='+$('#maxCost').val()">
                       <div class="slider">
                            <div id="slider"></div>
                            <?php echo '<script type="text/javascript">
                                jQuery("#slider").slider({
                                    min: 0,
                                    max: 2500,
                                    values: [($(\'#minCost\').val()),($(\'#maxCost\').val())],
                                    range: true,
                                    stop: function(event, ui) {
                                        minVal = ui.values[0];
                                        maxVal = ui.values[1];

                                        jQuery("input#minCost").val(minVal);
                                        jQuery("input#maxCost").val(maxVal);
                                    },
                                    slide: function(event, ui){
                                        minVal = ui.values[0];
                                        maxVal = ui.values[1];
                                        jQuery("input#minCost").val(minVal);
                                        jQuery("input#maxCost").val(maxVal);
                                    }
                                });
                            </script>'; ?>

                        </div>
                    </div>
                </div>
            </div>
        </aside> -->

        <section class="gm-section-content">
            <div class="gm-productlist-wrap">
                <div class="head">
                    <div class="block-view js-change-view">
                                                <a href="<?php echo $this->_tpl_vars['sGroupChangeTableUrl']; ?>
&table=thumb" class="thumb<?php if ($_REQUEST['table'] == 'thumb' || $_REQUEST['table'] == ''): ?> selected<?php endif; ?>" data-type="thumb"></a>
                    </div>

                    <div class="block-sort">
                        <span class="title">Сортувати:</span>
                        <select class="js-uniform" onchange="document.location=this.options[this.selectedIndex].value;">
                            <option <?php if ($_REQUEST['sort'] == 'name'): ?>selected="selected"<?php endif; ?> value="<?php echo $this->_tpl_vars['sSeoUrl']; ?>
<?php if ($this->_tpl_vars['iSeoUrlAmp']): ?>&sort=name<?php else: ?>sort=name<?php endif; ?>"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('по імені'); ?>
</option>
                            <option <?php if ($_REQUEST['way'] == 'up'): ?>selected="selected"<?php endif; ?> value="<?php echo $this->_tpl_vars['sSeoUrl']; ?>
<?php if ($this->_tpl_vars['iSeoUrlAmp']): ?>&sort=price&way=up<?php else: ?>sort=price/way=up<?php endif; ?>"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('зростанню ціни'); ?>
</option>
        					<option <?php if ($_REQUEST['way'] == 'down'): ?>selected="selected"<?php endif; ?> value="<?php echo $this->_tpl_vars['sSeoUrl']; ?>
<?php if ($this->_tpl_vars['iSeoUrlAmp']): ?>&sort=price&way=down<?php else: ?>sort=price/way=down<?php endif; ?>"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('зменшенню ціни'); ?>
</option>
                        </select>
                    </div>
                    <?php if ($_REQUEST['table'] == 'line'): ?>
                    <div class="block-sort">
                        <a class="btn" href="/?action=<?php if ($_REQUEST['action'] == 'catalog_promo'): ?>catalog_promo<?php else: ?>catalog_vid<?php endif; ?>&group=<?php echo $_REQUEST['group']; ?>
<?php if ($_REQUEST['vid']): ?>&vid=<?php echo $_REQUEST['vid']; ?>
<?php endif; ?>&catalog_export=1<?php if ($_REQUEST['action'] == 'catalog_promo'): ?>&promo=<?php echo $_REQUEST['promo']; ?>
<?php endif; ?>" style="margin: 0 50px;">
                            <span class="title"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('export_prices'); ?>
</span></a></div>
                    <?php endif; ?>
                    <div class="block-filter">
                        <a href="#" class="gm-link-dashed js-block-left-filter-toggle">Фильтры</a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php echo $this->_tpl_vars['sPriceTable']; ?>


        </section>
<div class="clear"></div>