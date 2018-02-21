<?php /* Smarty version 2.6.18, created on 2018-02-20 13:58:48
         compiled from index_include/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index_include/footer.tpl', 7, false),)), $this); ?>


<footer class="gm-block-footer">
    <div class="gm-mainer">
        <div class="block-logo">
            <a href="/"><img src="/image/_images/success-bg-bird.jpg" alt="" width="80px" height="80px"></a>
            <span class="date"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('copyright'); ?>
 - <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
</span>
        </div>

        <div class="block-phones">
                <?php echo $this->_tpl_vars['sPhone2']; ?>

                    </div>

        <?php echo $this->_tpl_vars['oLanguage']->GetText('bottom_links1_2'); ?>


        
        
        <div class="block-year">&copy; 2017</div>
        <div class="clear"></div>
        
        <div class="footer-description"></div>
    </div>
</footer>

<div class="gm-block-left-curtain close js-block-left-curtain">
    <div class="head">
        <div class="close js-block-left-curtain-toggle"></div>
        <?php if ($this->_tpl_vars['aAuthUser']['id'] && ! ( $this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aAuthUser']['login']) )): ?>
        <a class="enter already" href='/pages/dashboard'>Мой кабинет</a>
        <?php else: ?>
        <a class="enter already" href="javascript:void(0);" onclick="popupOpen('.js-popup-auth');">Войти</a>
        <?php endif; ?>
    </div>
    <ul class="body">
<?php $_from = $this->_tpl_vars['EcBrandGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['BrandGroup']):
?>
			<li>
				                <?php if ($this->_tpl_vars['BrandGroup']['sub']): ?>
                <a class="toggle" href="/?action=catalog_vid&group=<?php echo $this->_tpl_vars['id']; ?>
" onclick="document.location='/?action=catalog_vid&group=<?php echo $this->_tpl_vars['id']; ?>
'"><?php echo $this->_tpl_vars['BrandGroup']['name']; ?>
</a>
                <ul>
		    <?php if ($this->_tpl_vars['OLD_Interface']): ?>
                <?php $_from = $this->_tpl_vars['BrandGroup']['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id2'] => $this->_tpl_vars['Item']):
?>
                    <li><a href="/?action=catalog_brand&group=<?php echo $this->_tpl_vars['id']; ?>
&brand=<?php echo $this->_tpl_vars['Item']['id_brand']; ?>
"><?php echo $this->_tpl_vars['Item']['brand']; ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
       	    <?php else: ?>
							<?php $_from = $this->_tpl_vars['BrandGroup']['biglist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aBigListItem']):
?>
				  <?php if ($this->_tpl_vars['aBigListItem']): ?>
					<?php if ($this->_tpl_vars['aBigListItem']['types'] != 4 && $this->_tpl_vars['aBigListItem']['types'] != 2 || ( $_REQUEST['brand'] == $this->_tpl_vars['aBigListItem']['id'] && $this->_tpl_vars['aBigListItem']['types'] == 4 )): ?>
					<li><a class="gm_column-left-list__link
					<?php if (( $_REQUEST['promo'] == $this->_tpl_vars['aBigListItem']['id'] && $this->_tpl_vars['aBigListItem']['types'] == 1 && $_REQUEST['group'] == $this->_tpl_vars['aBigListItem']['id_group_br'] ) || ( $_REQUEST['brand'] == $this->_tpl_vars['aBigListItem']['id'] && $this->_tpl_vars['aBigListItem']['types'] == 4 )): ?>selected<?php endif; ?>" 
					" style="color: #5fb7c1;" href="<?php echo $this->_tpl_vars['aBigListItem']['href']; ?>
"style="white-space: nowrap;"><?php echo $this->_tpl_vars['aBigListItem']['name']; ?>
</a> </li>
					<?php endif; ?>
				  <?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
				<br>
						  <?php $_from = $this->_tpl_vars['BrandGroup']['col']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aColItem']):
?> 
					<?php $_from = $this->_tpl_vars['aColItem']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aListItem']):
?> 
						<li><a class="gm_column-mainvid <?php if ($_REQUEST['vid'] == $this->_tpl_vars['aListItem']['id']): ?>selected<?php endif; ?>" style="color: #5fb7c1;" href="<?php echo $this->_tpl_vars['aListItem']['href']; ?>
"><?php echo $this->_tpl_vars['aListItem']['name']; ?>
</a>	</li>
							<?php $_from = $this->_tpl_vars['aListItem']['sublist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aSubListItem']):
?>
								<li><a class="gm_column-childvid__link <?php if ($_REQUEST['vid'] == $this->_tpl_vars['aSubListItem']['id']): ?>selected<?php endif; ?>" style="color: #afbcc1;" href="<?php echo $this->_tpl_vars['aSubListItem']['href']; ?>
">&nbsp;&nbsp;<?php echo $this->_tpl_vars['aSubListItem']['name']; ?>
</a> </li>
							<?php endforeach; endif; unset($_from); ?>
					<?php endforeach; endif; unset($_from); ?>
		      <?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>

                <li><a class="show_all" href="/?action=catalog_vid&group=<?php echo $this->_tpl_vars['id']; ?>
"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Show all'); ?>
</a></li>
                </ul>
                <?php else: ?>
                <a href="/?action=catalog_group&group=<?php echo $this->_tpl_vars['id']; ?>
"><?php echo $this->_tpl_vars['BrandGroup']['name']; ?>
</a>
                <?php endif; ?>
            </li>
            
         <?php endforeach; endif; unset($_from); ?> 
          
    </ul>
</div>
