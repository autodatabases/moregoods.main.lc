<?php /* Smarty version 2.6.18, created on 2018-02-19 17:16:42
         compiled from index_include/popup.tpl */ ?>
<div class="gm-block-popup js-popup-auth" style="display: none;" >
    <div class="dark" onclick="popupClose('.js-popup-auth');"></div>
    <div class="block-popup auth-popup">
        <div class="close" onclick="popupClose('.js-popup-auth');"></div>
        <div class="auth-form">
        <form action="/" method='post'>
            <div class="head"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('entrance'); ?>
</div>
            <div class="gm-block-form">
                <div class="form-element">
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Login'); ?>
:</div>
                    <input type="text" name="login" value="">
                </div>
                <div class="form-element">
                    <span class="forget"><a class="gm-link-dashed" href="/pages/user_restore_password"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('lost password'); ?>
</a></span>
                    <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('password'); ?>
:</div>
                    <input type="password"  name="password" value="" style="padding-right: 80px;">
                </div>
                <div class="form-element">
                    <input class="gm-button floated" type="submit" value="Войти">
                    <input name="action" value="user_do_login" type="hidden">
                                    </div>
                 <a class="gm-button" href="/pages/user_new_account"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('register'); ?>
</a>
            </div>
            </form>
        </div>

        
        <div class="clear"></div>
    </div>
</div>