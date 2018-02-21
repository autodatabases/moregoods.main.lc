<?php /* Smarty version 2.6.18, created on 2018-02-19 20:34:07
         compiled from cart/form_check_logged.tpl */ ?>
<div class="auth-form" 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 0 -80px;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 0px 20px;
    position: relative;
	width: 340px;">
                <div class="head" style="font-size:20px">Я уже зарегистрирован</div>
                <div class="gm-block-form">
                    <div class="form-element">
                        <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</div>
                        <input maxlength="50" size="18" name=data[old_login] value="<?php echo $_REQUEST['data']['old_login']; ?>
" type="text">
                    </div>
                    <div class="form-element">
                        <span class="forget"><a class="gm-link-dashed" href="/pages/user_restore_password">Забыли пароль?</a></span>
                        <div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Password'); ?>
:</div>
                        <input maxlength="50" size="18" name=data[old_password] type="password" style="padding-right: 80px;">
                    </div>
                    <div class="form-element">
                        <input class="gm-button floated" style="margin: 22px 0px 22px 0px" type="submit" value="Войти">
                                            </div>
                </div>
            </div>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/order_by_phone_2.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			