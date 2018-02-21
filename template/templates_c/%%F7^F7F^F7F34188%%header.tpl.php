<?php /* Smarty version 2.6.18, created on 2018-02-08 17:31:27
         compiled from header.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<title><?php echo ''; ?><?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:title','global:title constant'); ?><?php echo ''; ?>
</title>
<meta name="description" content="<?php echo ''; ?><?php if ($this->_tpl_vars['template']['sPageDescription']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['template']['sPageDescription']; ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:meta_description','global:meta_description constant'); ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>
" />
<meta name="keywords" content="<?php echo ''; ?><?php if ($this->_tpl_vars['template']['sPageKeyword']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['template']['sPageKeyword']; ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:meta_keyword','global:meta_keyword constant'); ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>
" />
<meta http-equiv="content-type"	content="text/html; charset=<?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:default_encoding','utf-8'); ?>
" />
<link rel="SHORTCUT ICON" <?php if ($this->_tpl_vars['sFaviconType']): ?>type="<?php echo $this->_tpl_vars['sFaviconType']; ?>
"<?php endif; ?> href="<?php echo $this->_tpl_vars['oLanguage']->GetConstant('favicon','/favicon.ico'); ?>
" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
<link rel='stylesheet' href='https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Map/styles/map.css' />
<link rel='stylesheet' href='https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Calc/styles/calc.css' />
    <link rel="stylesheet" href="/css/fonts/font-awesome/css/font-awesome.min.css">
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php echo $this->_tpl_vars['sGAJavascript']; ?>

<?php echo $this->_tpl_vars['sGTMHeadJavascript']; ?>

<?php echo $this->_tpl_vars['template']['sHeaderResource']; ?>

<?php if ($this->_tpl_vars['bHeaderPrint']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header_print.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>

</head>