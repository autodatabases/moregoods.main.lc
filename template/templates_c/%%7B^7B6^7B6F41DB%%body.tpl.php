<?php /* Smarty version 2.6.18, created on 2018-02-19 20:17:56
         compiled from index_include/body.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'index_include/body.tpl', 48, false),array('modifier', 'capitalize', 'index_include/body.tpl', 54, false),)), $this); ?>

<?php if ($_REQUEST['action'] == 'home' || $_REQUEST['action'] == ''): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'home/banner_right.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endif; ?>
<div class="gm-mainer" <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?> class="for_manager"<?php endif; ?>>
    <div class="gm-block-crumbs">
    <?php if ($this->_tpl_vars['aCrumbs']): ?>
            <a href="/"><?php echo $this->_tpl_vars['oLanguage']->getMessage('main'); ?>
</a>
				            <!-- Хлебные крошки -->
				            <?php $_from = $this->_tpl_vars['aCrumbs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['crumb_ar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['crumb_ar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['aItem']):
        $this->_foreach['crumb_ar']['iteration']++;
?>
				                <?php if ($this->_tpl_vars['aItem']['link']): ?><a href="<?php echo $this->_tpl_vars['aItem']['link']; ?>
"><?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['aItem']['name'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
<?php if ($this->_tpl_vars['aItem']['link']): ?></a><?php endif; ?>
				                <?php if (! ($this->_foreach['crumb_ar']['iteration'] == $this->_foreach['crumb_ar']['total'])): ?>&nbsp;<?php endif; ?>
				            <?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
    </div>
    <?php if ($this->_tpl_vars['aPage']['name'] && $this->_tpl_vars['aPage']['name'] != 'Головна'): ?>
    <h1 class="page-name"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['aPage']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
&nbsp;</h1>
    <?php else: ?>
    <?php endif; ?>
<div class="gm-block-page">

                    <?php if ($_REQUEST['action'] != 'contact_form' && $_REQUEST['action'] != 'news' && $_REQUEST['action'] != 'user_new_account' && ! $this->_tpl_vars['oContent']->CheckDashboard($_REQUEST['action']) && $_REQUEST['action'] != 'cart_onepage_order' && $_REQUEST['action'] != 'cart_cart' && $_REQUEST['action'] != 'cart_payment_end' && $_REQUEST['action'] != 'catalog_vid' && $_REQUEST['action'] != 'catalog_promo'): ?>
                    <?php echo $this->_tpl_vars['sText']; ?>

                    					<hr>
					<?php elseif ($this->_tpl_vars['oContent']->CheckDashboard($_REQUEST['action']) && $_REQUEST['action'] != 'catalog_vid' && $_REQUEST['action'] != 'catalog_promo'): ?>
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index_include/dashboard.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($_REQUEST['action'] == 'catalog_vid' || $_REQUEST['action'] == 'catalog_promo'): ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index_include/dashboard_vid.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php else: ?>
						<?php echo $this->_tpl_vars['sText']; ?>

											<?php endif; ?>
</div>
</div>
<?php if ($_REQUEST['brand'] && ! $_REQUEST['vid']): ?>
    <?php echo $this->_tpl_vars['sTextLeft']; ?>

<?php endif; ?>
<?php if ($_REQUEST['action'] == 'home' || $_REQUEST['action'] == ''): ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'index_include/home_news.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['sTextLeft']; ?>


<div id="new_prop" 
	style="width: 100%; 
		height: 40px; 
        left: 0px;
		position: fixed; 
		background-color: #3f4c56;/*darkorchid; */
		bottom: 0px; 
		z-index: 900; 
		box-shadow: rgb(34, 34, 34) 0px 0px 20px 0px; 
		display: block; 
		opacity: 0.9;
        ">
<a href="/pages/news/21" style="text-decoration: none;">
  <div style="
    font-size: 1.5em;
    color: white;
    margin-left: auto;
    padding-top: 5px;
    margin-right: auto;
    width: 85%;
    text-align: center;
	cursor: pointer;">
    <span class="badge-2" data-promo=""  style="border-bottom: 1px white dashed;">Доставка по г.Чернигов БЕСПЛАТНО!
    </span>
  </div> 
</a>
</div>
<?php endif; ?>