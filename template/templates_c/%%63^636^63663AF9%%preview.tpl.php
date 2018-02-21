<?php /* Smarty version 2.6.18, created on 2018-01-13 14:50:18
         compiled from news/preview.tpl */ ?>
<div class="gm-block-page gm-block-article-view">
<h1><?php echo $this->_tpl_vars['aNewsRow']['short']; ?>
</h1>
    <div class="date"><?php echo $this->_tpl_vars['oContent']->GetMonthDay($this->_tpl_vars['aNewsRow']['date']); ?>
 <?php echo $this->_tpl_vars['oContent']->GetYear($this->_tpl_vars['aRow']['date']); ?>

    </div>

	    <?php echo $this->_tpl_vars['aNewsRow']['full']; ?>

</div>