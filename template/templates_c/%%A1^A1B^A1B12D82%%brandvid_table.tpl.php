<?php /* Smarty version 2.6.18, created on 2018-01-13 13:13:56
         compiled from index_include/brandvid_table.tpl */ ?>
<aside class="gm-aside-left">
            <nav class="gm-portal-menu">
                <ul <?php if ($this->_tpl_vars['sIdTable'] != ""): ?>id="<?php echo $this->_tpl_vars['sIdTable']; ?>
"<?php endif; ?>>
                
<?php $this->assign('iTr', '0'); ?>
<?php unset($this->_sections['d']);
$this->_sections['d']['name'] = 'd';
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['aItem']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['d']['show'] = true;
$this->_sections['d']['max'] = $this->_sections['d']['loop'];
$this->_sections['d']['step'] = 1;
$this->_sections['d']['start'] = $this->_sections['d']['step'] > 0 ? 0 : $this->_sections['d']['loop']-1;
if ($this->_sections['d']['show']) {
    $this->_sections['d']['total'] = $this->_sections['d']['loop'];
    if ($this->_sections['d']['total'] == 0)
        $this->_sections['d']['show'] = false;
} else
    $this->_sections['d']['total'] = 0;
if ($this->_sections['d']['show']):

            for ($this->_sections['d']['index'] = $this->_sections['d']['start'], $this->_sections['d']['iteration'] = 1;
                 $this->_sections['d']['iteration'] <= $this->_sections['d']['total'];
                 $this->_sections['d']['index'] += $this->_sections['d']['step'], $this->_sections['d']['iteration']++):
$this->_sections['d']['rownum'] = $this->_sections['d']['iteration'];
$this->_sections['d']['index_prev'] = $this->_sections['d']['index'] - $this->_sections['d']['step'];
$this->_sections['d']['index_next'] = $this->_sections['d']['index'] + $this->_sections['d']['step'];
$this->_sections['d']['first']      = ($this->_sections['d']['iteration'] == 1);
$this->_sections['d']['last']       = ($this->_sections['d']['iteration'] == $this->_sections['d']['total']);
?>
<?php $this->assign('aRow', $this->_tpl_vars['aItem'][$this->_sections['d']['index']]); ?>
<?php $this->assign('iTr', $this->_tpl_vars['iTr']+1); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sDataTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endfor; endif; ?>
                </ul>
            </nav>
        </aside>
        <section class="gm-section-content">
	        <div class="gm-banner-index portal js-banner-index">
	           <div class="mainer">
	              <div class="wrapper">
						<?php $_from = $this->_tpl_vars['aBannerVid']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aSingleBannerVid']):
?>
						<div><a href="<?php echo $this->_tpl_vars['aSingleBannerVid']['link']; ?>
">
						<img src="<?php echo $this->_tpl_vars['aSingleBannerVid']['image']; ?>
"
							alt="<?php echo $this->_tpl_vars['aSingleBannerVid']['name']; ?>
" style="width:907px; height: 339px;"/>
							<img class="small" src="<?php echo $this->_tpl_vars['aSingleBannerVid']['image']; ?>
" alt="">
							</a>
						</div>
						<?php endforeach; endif; unset($_from); ?>
				  </div>  
	          </div>
	        </div>
        </section>
<div class="clear"></div>