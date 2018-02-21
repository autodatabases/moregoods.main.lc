<?php /* Smarty version 2.6.18, created on 2018-02-07 11:06:18
         compiled from catalog/review.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'catalog/review.tpl', 10, false),)), $this); ?>
<td>
                                <div class="element <?php if ($this->_tpl_vars['aRow']['parent_id']): ?>short<?php endif; ?>">
                                    <div class="user-name">
                                    	<?php if ($this->_tpl_vars['aRow']['type'] == 'manager'): ?><?php echo $this->_tpl_vars['oLanguage']->getMessage('rewiew shop stuff'); ?>
 <?php else: ?><nobr><?php echo $this->_tpl_vars['aRow']['name']; ?>
</nobr><?php endif; ?>
                                    </div>
                                    <div class="body">
                                        <div class="user-info">
                                            <img src="/image/design/user-icon.png" alt="">
                                            <div class="date">
                                                <?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['post'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>

                                            </div>
                                            <div class="tgp-rating-sub">
                                                <span style="width: <?php echo $this->_tpl_vars['aRow']['stars']; ?>
%"></span>
                                            </div>
                                        </div>
                                        <div class="comment-text">
                                            <?php echo $this->_tpl_vars['aRow']['text']; ?>

                                            <br />
                                            <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
                                            <a class="answer" 
                                            onclick="xajax_process_browse_url('/?action=catalog_review_edit&data[id]=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&data[ref]=<?php echo $this->_tpl_vars['sRef']; ?>
');$('.js-add-comment-form').slideToggle(150);return false;"  
                                            href="#">
												<?php echo $this->_tpl_vars['oLanguage']->getMessage('reply'); ?>

											</a> 
											
											<a class="answer" onclick="xajax_process_browse_url('/?action=catalog_review_edit&data[id]=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&data[ref]=<?php echo $this->_tpl_vars['sRef']; ?>
&data[edit]=1');$('.js-add-comment-form').slideToggle(150);return false;"  href="#">
											<img title="<?php echo $this->_tpl_vars['oLanguage']->getMessage('edit'); ?>
" src="/image/design/edit.png"></a> 
											
											<a class="answer" onclick="if (confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage('confirm remove review'); ?>
')) 
											xajax_process_browse_url('/?action=catalog_review_remove&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
'); return false;" href="#">
											<img src="/image/delete.png" alt="remove"></a>
											<?php endif; ?>
                                        </div>
                                    </div>
                                </div>

</td>