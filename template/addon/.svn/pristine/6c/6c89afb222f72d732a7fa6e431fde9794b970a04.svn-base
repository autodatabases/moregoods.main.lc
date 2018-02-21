<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"/>
    <meta name="msapplication-tap-highlight" content="no">
    
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Milestone">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Milestone">

    <meta name="theme-color" content="#4C7FF0">
    
    <title>{$sProjectName} - MPanel v{$sMpanelVersion}</title>

    <!-- build:css -->
    <link rel="stylesheet" href="/libp/mpanel/css/bootstrap.css"/>
    <link rel="stylesheet" href="/libp/mpanel/css/font-awesome.css"/>
    <link rel="stylesheet" href="/libp/mpanel/css/app.css" id="load_styles_before"/>
    <link  rel='stylesheet'href='/css/select2.min.css'/>
    <!-- endbuild -->
    
    <LINK href="/libp/mpanel/css/css.css" rel=stylesheet type=text/css>
    <script language="javascript" type="text/javascript" src="/js/general.js?2436"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/functions.js?268"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/color_table.js?113"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/browser_functions.js?268"></script>
    <script language="javascript" type="text/javascript" src="/libp/popcalendar/popcalendar.js?2291"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/uploader.js"></script>
    <script type="text/javascript" src="/libp/js/table.js"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/ColorPicker2.js"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/custom.js"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/mpanel.js"></script>
    <script language="javascript" type="text/javascript" src="/libp/mpanel/js/opacity.js"></script>
    <script language="javascript" type="text/javascript" src="/libp/ckeditor/ckeditor.js"></script>
    <script language="javascript" type="text/javascript" src="/libp/ckeditor/config.js?3"></script>
    <link rel="stylesheet" href="/libp/ckeditor/styles.css">
    
    <!-- footable -->
   
    <link rel="stylesheet" href="/libp/footable/css/footable.bootstrap.min.css">
    <!-- footable -->
  </head>
  <body>

    <div class="app">
      <!--sidebar panel-->
      <div class="off-canvas-overlay" data-toggle="sidebar"></div>
      <div class="sidebar-panel">
        <div class="brand">
          <!-- toggle offscreen menu -->
          <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen hidden-lg-up">
            <i class="material-icons">menu</i>
          </a>
          <!-- /toggle offscreen menu -->
          <!-- logo -->
          <a class="brand-logo">
            <img class="expanding-hidden" src="/libp/mpanel/images/title.png" alt=""/>
          </a>
          <!-- /logo -->
        </div>
        <div class="card card-block">
          <p class="card-text">
            Welcome: {$aAdmin.login}<br>
            You Last Login: {$aAdmin.last_login}<br>
            From: {$aAdmin.last_referer}<br>
          {if $sVersionTecDoc}
            TecDoc: {$sVersionTecDoc}
          {/if}
          </p>
        </div>
        <!-- main navigation -->
        <nav>
          <p class="nav-title">NAVIGATION</p>
          {include file="mpanel/dtree_new.tpl"}
         </nav>
        <!-- /main navigation -->
      </div>
      <!-- /sidebar panel -->
      <!-- content panel -->
      <div class="main-panel">
        <!-- top header -->
        <nav class="header navbar">
          <div class="header-inner">
            <div class="navbar-item navbar-spacer-right brand hidden-lg-up">
              <!-- toggle offscreen menu -->
              <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen">
                <i class="material-icons">menu</i>
              </a>
              <!-- /toggle offscreen menu -->
              <!-- logo -->
              <a class="brand-logo hidden-xs-down">
                <img src="images/logo_white.png" alt="logo"/>
              </a>
              <!-- /logo -->
            </div>
            <a class="navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="/mpanel/login.php">
              <span id="win_head">{$sWinHead}</span>
              {*<span id="path">{$sPath}</span>*}
            </a>
            
            {*<div class="navbar-item nav navbar-nav">
              <div class="nav-item nav-link dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                  <span>English</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
{foreach from=$aLanguageList item=aItem}
<A class="dropdown-item" href="?action=language_mpanel_change&amp;content={$aItem.code}" onclick="xajax_process_browse_url(this.href);  return false;">{$aItem.name}</A>
{/foreach}
                </div>
              </div>
            </div>*}

            <div class="navbar-item nav navbar-nav">
                <div class="nav-item nav-link dropdown">
                    <span id="loading_id"><img style="visibility: hidden" height="16" src="/libp/mpanel/images/wait.gif" width="16" /></span>
                </div>
            </div>
            
          </div>
        </nav>
        <!-- /top header -->

        <!-- main area -->
        <div class="main-content">
          <div class="content-view">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-block">
                    <div id="sub_menu"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
        		  <div class="card card-block" id="win_text">
        		  <div id="result_text"><div class="empty_p">&nbsp;</div></div>
            		  {$sText}
        		  </div>
              </div>
            </div>
          </div>
          <!-- bottom footer -->
          <div class="content-footer">
            <nav class="footer-right">
            </nav>
            <nav class="footer-left">
              <ul class="nav">
                <li>
                  <a href="javascript:;">
                    <span>Copyright</span>
                    &copy; MstarProject
                  </a>
                </li>
                
              </ul>
            </nav>
          </div>
          <!-- /bottom footer -->
        </div>
        <!-- /main area -->
      </div>
      <!-- /content panel -->

      

    </div>
{literal}
    <script type="text/javascript">
      window.paceOptions = {
        document: true,
        eventLag: true,
        restartOnPushState: true,
        restartOnRequestAfter: true,
        ajax: {
          trackMethods: [ 'POST','GET']
        }
      };
    </script>
{/literal}
    <!-- build:js -->
    <script src="/libp/mpanel/js/jquery.js"></script>
    <script src="/libp/mpanel/js/pace.js"></script>
    <script src="/libp/mpanel/js/tether.js"></script>
    <script src="/libp/mpanel/js/bootstrap.js"></script>
    <script src="/libp/mpanel/js/fastclick.js"></script>
    <script src="/libp/mpanel/js/constants.js"></script>
    <script src="/libp/mpanel/js/main.js"></script>
    <script src='/js/select2.min.js'></script>
    <!-- endbuild -->
    
     <script language="javascript" type="text/javascript" src="/libp/footable/js/footable.min.js"></script>
    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
    <!-- @@@@@@@@@@@@@@@@@@  XAJAX Javascript Code @@@@@@@@@@@@@@@ -->
    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
    {$sXajaxJavascript}
    <script>
    xajax.loadingFunction = show_loading;
    xajax.doneLoadingFunction = hide_loading;
    </script>
    <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
  </body>
</html>