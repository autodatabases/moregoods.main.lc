<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<title>{strip}
	{$oLanguage->GetConstant('global:title','global:title constant')}{/strip}</title>
<meta name="description" content="{strip}{if $template.sPageDescription}{$template.sPageDescription}
	{else}{$oLanguage->GetConstant('global:meta_description','global:meta_description constant')}{/if}{/strip}" />
<meta name="keywords" content="{strip}{if $template.sPageKeyword}{$template.sPageKeyword}
	{else}{$oLanguage->GetConstant('global:meta_keyword','global:meta_keyword constant')}{/if}{/strip}" />
<meta http-equiv="content-type"	content="text/html; charset={$oLanguage->GetConstant('global:default_encoding','utf-8')}" />
<link rel="SHORTCUT ICON" {if $sFaviconType}type="{$sFaviconType}"{/if} href="{$oLanguage->GetConstant('favicon','/favicon.ico')}" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
<link rel='stylesheet' href='https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Map/styles/map.css' />
<link rel='stylesheet' href='https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Calc/styles/calc.css' />
    <link rel="stylesheet" href="/css/fonts/font-awesome/css/font-awesome.min.css">
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
{$sGAJavascript}
{$sGTMHeadJavascript}
{$template.sHeaderResource}
{if $bHeaderPrint} {include file=header_print.tpl} {/if}

</head>