<?php /* Smarty version 2.6.18, created on 2017-05-16 19:38:12
         compiled from mpanel/dtree.tpl */ ?>
 
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<div class="dtree_hd">
<a href="javascript: d.openAll();"><img border="0" src="/libp/mpanel/images/dtree/expandall.png"/></a>
<a href="javascript: d.closeAll();"><img border="0" src="/libp/mpanel/images/dtree/collapseall.png"/></a>
</div>

<script type="text/javascript">
<!--
d = new dTree('d');
d.add(0,-1,'&nbsp;<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('My dSAP menu'); ?>
');
d.add(1001,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Home'); ?>
','#','','','','/libp/mpanel/images/dtree/colorman.png'
,'/libp/mpanel/images/dtree/colorman.png',
' xajax_process_browse_url(\'?action=splash_xajax&click_from_menu=1\');  return false;');

<?php if ($this->_tpl_vars['aAdmin']['login'] == $this->_tpl_vars['CheckLogin']): ?>
d.add(50,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Admin regulations'); ?>
','#','','','','/image/mpanel/admin_regulations.png','/image/mpanel/admin_regulations.png',
'xajax_process_browse_url(\'?action=admin_regulations&lick_from_menu=1\'); return false;');
<?php endif; ?>

d.add(1,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Configuration'); ?>
','#','','','/libp/mpanel/images/dtree/log.png'
,'/libp/mpanel/images/dtree/log.png');
d.add(5,1,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('General constants'); ?>
','#','','','','/libp/mpanel/images/dtree/log.png'
,'/libp/mpanel/images/dtree/log.png',
'xajax_process_browse_url(\'?action=general_constant&click_from_menu=1\'); return false;');
d.add(10,1,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Constants'); ?>
','#','','','','/libp/mpanel/images/dtree/log.png'
,'/libp/mpanel/images/dtree/log.png',
'xajax_process_browse_url(\'?action=constant&click_from_menu=1\'); return false;');
d.add(11,1,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Currencies'); ?>
','#','','','','/libp/mpanel/images/dtree/log.png'
,'/libp/mpanel/images/dtree/log.png',
'xajax_process_browse_url(\'?action=currency&click_from_menu=1\'); return false;');
d.add(12,1,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Languages'); ?>
','#','','','','/libp/mpanel/images/dtree/log.png'
,'/libp/mpanel/images/dtree/log.png',
' xajax_process_browse_url(\'?action=language&click_from_menu=1\');  return false;');
d.add(13,1,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Administrators'); ?>
','#','','','','/libp/mpanel/images/dtree/log.png'
,'/libp/mpanel/images/dtree/log.png',
'xajax_process_browse_url(\'?action=admin&click_from_menu=1\'); return false;');

d.add(100,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Content'); ?>
','#','','','','');
d.add(101,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Dropdown Manager'); ?>
','#','','','','',''
,'xajax_process_browse_url(\'?action=drop_down&click_from_menu=1\'); return false;');
d.add(102,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Content Editor'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=content_editor&click_from_menu=1\');  return false;');
d.add(104,100,'<?php echo $this->_tpl_vars['oLanguage']->getDMessage('Dropdown Additional'); ?>
','#','','','','',''
		,'xajax_process_browse_url(\'?action=drop_down_additional&click_from_menu=1\'); return false;');
d.add(106,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Message translate'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=translate_message&click_from_menu=1\');  return false;');
d.add(107,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Text translate'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=translate_text&click_from_menu=1\');  return false;');
d.add(107,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Translate'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=translate&click_from_menu=1\');  return false;');
d.add(110,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Templates'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=template&click_from_menu=1\');  return false;');
d.add(112,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('News'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=news&click_from_menu=1\');  return false;');
d.add(140,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Delivery types'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=delivery_type&click_from_menu=1\');  return false;');
d.add(150,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Payment types'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=payment_type&click_from_menu=1\');  return false;');
d.add(155,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Rating'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=rating&click_from_menu=1\');  return false;');
d.add(156,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('popular products'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=popular_products&click_from_menu=1\');  return false;');
d.add(157,100,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Caorusel Editor'); ?>
','#','','','','',''
,' xajax_process_browse_url(\'?action=banner&click_from_menu=1\');  return false;');




d.add(200,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Users'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png');
d.add(201,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Customer groups'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=customer_group&click_from_menu=1\');  return false;');
d.add(202,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Customer type'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=customer_type&click_from_menu=1\');  return false;');
d.add(203,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Customers'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=customer&click_from_menu=1\');  return false;');
d.add(204,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Manager'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=manager&click_from_menu=1\');  return false;');
d.add(205,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Provider groups'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=provider_group&click_from_menu=1\');  return false;');
// d.add(207,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Provider regions'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
// ,'/libp/mpanel/images/dtree/groupevent.png',''
// ,' xajax_process_browse_url(\'?action=provider_region&click_from_menu=1\');  return false;');
d.add(210,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Providers'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=provider&click_from_menu=1\');  return false;');
d.add(231,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Dynamic discounts'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=discount&click_from_menu=1\');  return false;');
d.add(240,200,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Account'); ?>
','#','','','/libp/mpanel/images/dtree/groupevent.png'
,'/libp/mpanel/images/dtree/groupevent.png',''
,' xajax_process_browse_url(\'?action=account&click_from_menu=1\');  return false;');



d.add(300,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Customer support'); ?>
','#','','','/libp/mpanel/images/dtree/aim.png'
,'/libp/mpanel/images/dtree/aim.png');
d.add(312,300,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Context hints'); ?>
','#','','','/libp/mpanel/images/dtree/aim.png'
,'/libp/mpanel/images/dtree/aim.png',''
,' xajax_process_browse_url(\'?action=context_hint&click_from_menu=1\');  return false;');

d.add(400,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Logs'); ?>
','#','','','/libp/mpanel/images/dtree/notebook.png'
,'/libp/mpanel/images/dtree/notebook.png');
d.add(401,400,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Finance log'); ?>
','#','','','/libp/mpanel/images/dtree/notebook.png'
,'/libp/mpanel/images/dtree/notebook.png',''
,' xajax_process_browse_url(\'?action=log_finance&click_from_menu=1\');  return false;');
d.add(413,400,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Mail Queue'); ?>
','#','','','/libp/mpanel/images/dtree/notebook.png'
,'/libp/mpanel/images/dtree/notebook.png',''
,' xajax_process_browse_url(\'?action=log_mail&click_from_menu=1\');  return false;');
d.add(420,400,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Visit log'); ?>
','#','','','/libp/mpanel/images/dtree/notebook.png'
,'/libp/mpanel/images/dtree/notebook.png',''
,' xajax_process_browse_url(\'?action=log_visit&click_from_menu=1\');  return false;');
d.add(425,400,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Log Admin'); ?>
','#','','','/libp/mpanel/images/dtree/notebook.png'
,'/libp/mpanel/images/dtree/notebook.png',''
,' xajax_process_browse_url(\'?action=log_admin&click_from_menu=1\');  return false;');
//d.add(435,400,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Rating log'); ?>
','#','','','/libp/mpanel/images/dtree/notebook.png'
//,'/libp/mpanel/images/dtree/notebook.png',''
//,' xajax_process_browse_url(\'?action=rating_log&click_from_menu=1\');  return false;');


// d.add(700,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Directory'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png');
// d.add(749,700,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Office'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=office&click_from_menu=1\');  return false;');
// d.add(750,700,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Office country'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=office_country&click_from_menu=1\');  return false;');
// d.add(751,700,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Office region'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=office_region&click_from_menu=1\');  return false;');
// d.add(752,700,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Office city'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=office_city&click_from_menu=1\');  return false;');


// d.add(800,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Auto catalog'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png');
// d.add(801,800,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Catalog list'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=cat&click_from_menu=1\');  return false;');
// d.add(811,800,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Parameter Parts'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=cat_part&click_from_menu=1\');  return false;');
// d.add(815,800,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Cat pref'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=cat_pref&click_from_menu=1\');  return false;');
// d.add(816,800,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Cat region'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=cat_region&click_from_menu=1\');  return false;');
// d.add(821,800,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Price'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=price&click_from_menu=1\');  return false;');
// d.add(830,800,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Price group'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
// ,'/libp/mpanel/images/dtree/contents.png',''
// ,' xajax_process_browse_url(\'?action=price_group&click_from_menu=1\');  return false;');



d.add(900,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Obriy'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png');
d.add(901,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('brand'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_brand&click_from_menu=1\');  return false;');
d.add(902,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('brand group'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_brand_group&click_from_menu=1\');  return false;');
d.add(903,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('brand in group'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_brand_in_group&click_from_menu=1\');  return false;');
d.add(904,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('distributor'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_distributor&click_from_menu=1\');  return false;');
d.add(905,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('distributor region'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_distributor_region&click_from_menu=1\');  return false;');
d.add(906,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('region'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_region&click_from_menu=1\');  return false;');
d.add(907,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('vid'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_vid&click_from_menu=1\');  return false;');
d.add(908,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('products'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_products&click_from_menu=1\');  return false;');
d.add(909,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('product in vid'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_product_in_vid&click_from_menu=1\');  return false;');
d.add(912,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('price'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_price&click_from_menu=1\');  return false;');
d.add(913,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('stock'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_stock&click_from_menu=1\');  return false;');
d.add(914,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('vt'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_vt&click_from_menu=1\');  return false;');
d.add(915,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('discounts'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_discounts&click_from_menu=1\');  return false;');
d.add(916,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('matrica'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_matrica&click_from_menu=1\');  return false;');
d.add(917,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('condition_h'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_condition_h&click_from_menu=1\');  return false;');
d.add(918,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('condition_d'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_condition_d&click_from_menu=1\');  return false;');
d.add(919,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('group_p'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_group_p&click_from_menu=1\');  return false;');
d.add(920,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('brand in region'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_brand_in_region&click_from_menu=1\');  return false;');
d.add(921,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('ec_variable'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_variable&click_from_menu=1\');  return false;');
d.add(922,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('ec_val'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_val&click_from_menu=1\');  return false;');
d.add(923,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('ec_antbl'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_antbl&click_from_menu=1\');  return false;');
d.add(924,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('ec_anval'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=ec_anval&click_from_menu=1\');  return false;');
d.add(925,900,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('net_city'); ?>
','#','','','/libp/mpanel/images/dtree/contents.png'
,'/libp/mpanel/images/dtree/contents.png',''
,' xajax_process_browse_url(\'?action=net_city&click_from_menu=1\');  return false;');


		

d.add(10002,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Trash'); ?>
','#','','','','/libp/mpanel/images/dtree/trashcan_full.png'
,'/libp/mpanel/images/dtree/trashcan_full.png',
'xajax_process_browse_url(\'?action=trash&click_from_menu=1\'); return false;');

d.add(10003,0,'<?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Logout'); ?>
','./?action=quit','','','/libp/mpanel/images/dtree/exit.gif');
document.write(d);
//-->
        </script>
<br/>

</div>