<?php /* Smarty version 2.6.18, created on 2018-02-08 15:29:46
         compiled from addon/mpanel/login.tpl */ ?>
<HTML>
<HEAD>
<TITLE>Administrator</TITLE>
<META content="text/html; charset=<?php echo $this->_tpl_vars['aGeneralConf']['Charset']; ?>
" http-equiv=Content-Type>
<link rel="SHORTCUT ICON" href="<?php echo $this->_tpl_vars['sMainUrlHttp']; ?>
favicon.ico">
<LINK href="/libp/mpanel/css/css.css?2" rel=stylesheet type=text/css>

<script language="javascript" type="text/javascript" src="/js/general.js?2436"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/functions.js?268"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/color_table.js?114"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/browser_functions.js?268"></script>

<script language="javascript" type="text/javascript" src="/libp/popcalendar/popcalendar.js?2291"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/uploader.js"></script>

<link rel="StyleSheet" href="/libp/mpanel/dtree/dtree.css" type="text/css" />
<script type="text/javascript" src="/libp/mpanel/dtree/dtree.js"></script>

<script type="text/javascript" src="/libp/js/table.js"></script>

<script language="javascript" type="text/javascript" src="/libp/mpanel/js/ColorPicker2.js"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/custom.js"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/mpanel.js"></script>
<script language="javascript" type="text/javascript" src="/libp/mpanel/js/opacity.js"></script>

<script language="javascript" type="text/javascript" src="/libp/jquery/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/libp/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="/libp/ckeditor/config.js?3"></script>
<link rel="stylesheet" href="/libp/ckeditor/styles.css">

<?php echo $this->_tpl_vars['sHeadAdditional']; ?>


<script type="text/javascript">
  fadeOpacity.addRule('oShowResult', 0, 1, 10);
  fadeOpacity.addRule('oHideResult', 1, 0, 200);
</script>

</HEAD>
<BODY>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>

	<td class="left_col">
		<!-- Left Column -->
		<!-- Inside Left Column -->

<table width=100%>
<tr>
	<td width=50% align=right><b>Welcome</b></td>
	<td><?php echo $this->_tpl_vars['aAdmin']['login']; ?>
</td>
</tr>
<tr>
	<td align=right><b>You Last Login:</b></td>
    <td><?php echo $this->_tpl_vars['aAdmin']['last_login']; ?>
</td>
</tr>
<tr>
	<td align=right><b>From:</b></td>
	<td><?php echo $this->_tpl_vars['aAdmin']['last_referer']; ?>
</td>
</tr>

</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mpanel/dtree.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		</td>
		<!-- Inside Left Column -->
		<!-- Left Column -->
	</td>

	<td class="right_col" >
        <a name='right_col'></a>
		<!-- Rigth Area -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="dsap_title">
				<!-- Right title-->
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="50%" valign="middle" align="left">

				<a id="hide-left-col" href="javascript:void(0);" > << </a>&nbsp;&nbsp;&nbsp;Administrator




						<span id="loading_id"><img style="visibility: hidden" height="16" src="/libp/mpanel/images/wait.gif" width="16" /></span>
					</td>
					<td align="right" valign="middle">
						<a href='./login.php' target=_blank
							></a>

					</td>
				</tr>
				</table>
				<!-- Right title-->

			</td>
		</tr>
		<tr>
			<td width="100%" height="100%">
				<!-- Content Area -->
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td class="cont_hd">
						<table cellspacing="0" cellpadding="0" width="100%">
					  	<tr>
						  	<td id="win_head" class="modules"><?php echo $this->_tpl_vars['sWinHead']; ?>
</td>
					  		<td id="path" class="path"><?php echo $this->_tpl_vars['sPath']; ?>
</td>
					  </tr>
					  </table>
					</td>
				</tr>
				<tr>
					<td height="100%" valign="top">
						<div id="result_text"><div class="empty_p">&nbsp;</div></div>

						<table class="main_window" cellpadding="0" cellspacing="0">
						<thead>
							<tr >
 								<th align="left">
 									<a href="#" target="_blank"><img src="/libp/mpanel/images/small/help.gif" alt="View mp Help"></a>
 								</th>

<th align="right">
	<div id="sub_menu">

	</div></th>
							</TR>
						</thead>
						<tr>
							<td colspan="2">
								<div id="win_text"><?php echo $this->_tpl_vars['sText']; ?>
</div>
							</td>
						</tr>
						</table>

 					</td>
				</tr>
				</table>

				<!-- Content Area -->

			</td>
		</tr>
		</table>
		<!-- Rigth Area -->
	</td>
</tr>
</table>
<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
<!-- @@@@@@@@@@@@@@@@@@  XAJAX Javascript Code @@@@@@@@@@@@@@@ -->
<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->




<?php echo $this->_tpl_vars['sXajaxJavascript']; ?>

<script>
xajax.loadingFunction = show_loading;
xajax.doneLoadingFunction = hide_loading;
</script>

<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
</BODY>
</HTML>

<?php echo '
<script type="text/javascript">
	$("a#hide-left-col").click(function() {
    if($(".left_col").css("display") == "none"){
      $(".left_col").css("display", "");
      $(this).html(\'<<\');
    } else {
      $(".left_col").css("display", "none");
      $(this).html(\'>>\');
    }
});
</script>
'; ?>