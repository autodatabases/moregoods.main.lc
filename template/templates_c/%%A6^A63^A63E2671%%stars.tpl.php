<?php /* Smarty version 2.6.18, created on 2017-05-15 18:46:18
         compiled from catalog/stars.tpl */ ?>
<span id="id_stars_<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
" class="tgp-rating">
<div style="float:left;" class="ak-rating r-<?php echo $this->_tpl_vars['sStars']; ?>
" 
<?php if ($this->_tpl_vars['aAuthUser']['id']): ?><?php if (! $this->_tpl_vars['sMyStars']): ?>onclick="xajax_process_browse_url('/?action=catalog_stars&item_code=<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
'); 
ShowPopup('100px');return false;"<?php endif; ?><?php else: ?>onclick="alert('<?php echo $this->_tpl_vars['oLanguage']->getMessage('vote nonreg'); ?>
');return false;"<?php endif; ?>>
</div>
</span>
<?php echo $this->_tpl_vars['sStars']/10; ?>
 / 5