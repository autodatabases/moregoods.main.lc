<?php /* Smarty version 2.6.18, created on 2018-02-19 20:25:14
         compiled from index_include/home_news.tpl */ ?>
<?php if ($this->_tpl_vars['aNews']): ?><div class="gm-mainer">
    
    <ul class="gm-block-news preview">
    <?php $_from = $this->_tpl_vars['aNews']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
        <li class="news-element">
            <div class="image"><a href="/pages/news/<?php echo $this->_tpl_vars['aItem']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['aItem']['image']; ?>
" alt="" style="max-width: 180px;max-height:180px"></a></div>
            <div class="date"><?php echo $this->_tpl_vars['oLanguage']->GetPostDate($this->_tpl_vars['aItem']['post_date']); ?>
</div>
           <?php if ($this->_tpl_vars['aItem']['page_description']): ?> <div class="name"><a href="/pages/news/<?php echo $this->_tpl_vars['aItem']['id']; ?>
"><?php echo $this->_tpl_vars['aItem']['page_description']; ?>
</a></div><?php endif; ?>
            <div class="description"><?php echo $this->_tpl_vars['aItem']['short']; ?>
</div>
            </li>
         <?php endforeach; endif; unset($_from); ?>   
        <li class="news-empty"></li>
        <li class="news-empty"></li>
        <li class="news-empty"></li>
    </ul>
    <div class="gm-block-news-more">
        <span><a class="gm-link-dashed" href="/pages/news"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('all_news_and_action'); ?>
</a></span>
    </div>
</div><?php endif; ?>