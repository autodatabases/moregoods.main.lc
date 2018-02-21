<?php /* Smarty version 2.6.18, created on 2018-02-20 12:33:03
         compiled from contact_form/template.tpl */ ?>

<!--<map name="regions_map" align="center">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick="set_contacts(<?php echo $this->_tpl_vars['allContacts'][49713]['adress']; ?>
,<?php echo $this->_tpl_vars['allContacts'][49713]['email']; ?>
,<?php echo $this->_tpl_vars['allContacts'][49713]['phone1']; ?>
,<?php echo $this->_tpl_vars['allContacts'][49713]['phone2']; ?>
,<?php echo $this->_tpl_vars['allContacts'][49713]['phone3']; ?>
,<?php echo $this->_tpl_vars['allContacts'][49713]['working_hours']; ?>
)"<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=49713'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','49713' ,'b1',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','49713' ,'b1',  'hidden')" shape="POLY" coords="272,69,276,154,280,181,327,169,339,147,362,122,351,112,315,101,301,63,286,65">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=64380'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','64380' ,'b2',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','64380' ,'b2',  'hidden')" shape="POLY" coords="290,218,280,185,329,170,360,132,388,189,335,203">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=50345'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','50345' ,'b3',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','50345' ,'b3',  'hidden')" shape="POLY" coords="53,190,35,167,39,145,93,102,129,134,94,157,77,173">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=00000'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b4',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b4',  'hidden')" shape="POLY" coords="11,199,34,229,92,235,77,210,46,190,26,172,19,190">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=66015'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','66015' ,'b5',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','66015' ,'b5',  'hidden')" shape="POLY" coords="205,127,197,88,222,56,265,58,280,144,256,160,243,147,209,148">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=151304');return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','151304','b6',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','151304','b6',  'hidden')" shape="POLY" coords="482,328,448,273,471,267,468,241,499,235,551,268,551,296">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=55491'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','55491' ,'b7',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','55491' ,'b7',  'hidden')" shape="POLY" coords="85,50,93,94,124,113,142,96,160,78,144,54,141,36,104,37">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=103567');return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','103567','b8',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','103567','b8',  'hidden')" shape="POLY" coords="199,217,202,186,216,185,214,153,269,160,290,220,267,239,230,233,213,220">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=52284'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','52284' ,'b9',  'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','52284' ,'b9',  'hidden')" shape="POLY" coords="157,210,124,194,109,176,106,155,146,126,162,124,154,162,155,198">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=59307'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','59307' ,'b10', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','59307' ,'b10', 'hidden')" shape="POLY" coords="397,109,396,51,409,20,441,44,441,71,480,97,482,119,444,132,431,115">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=172664');return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','172664','b11', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','172664','b11', 'hidden')" shape="POLY" coords="131,128,124,108,152,101,153,64,147,34,219,55,194,110,158,123">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=172659');return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','172659','b12', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','172659','b12', 'hidden')" shape="POLY" coords="370,125,432,116,482,167,443,201,390,174,375,143">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=29790'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','29790' ,'b13', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','29790' ,'b13', 'hidden')" shape="POLY" coords="222,377,259,324,292,325,254,243,297,237,333,292,309,343,277,377,239,387">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=63132'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','63132' ,'b14', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','63132' ,'b14', 'hidden')" shape="POLY" coords="300,240,346,241,368,259,397,246,395,301,357,314,335,314,330,300,306,258">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=00000'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b15', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b15', 'visible')" shape="POLY" coords="582,125,646,148,649,232,620,231,584,194,569,170,570,137">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=00000'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b16', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b16', 'visible')" shape="POLY" coords="387,379,429,344,498,382,534,372,534,391,438,430,422,399,404,384">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=55912'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','55912' ,'b17', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','55912' ,'b17', 'hidden')" shape="POLY" coords="283,227,375,196,398,188,426,206,384,256,332,238,295,239">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=30608'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','30608' ,'b18', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','30608' ,'b18', 'hidden')" shape="POLY" coords="369,335,367,316,400,299,403,271,440,273,477,325,460,339,392,345">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=286985');return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','286985','b19', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','286985','b19', 'hidden')" shape="POLY" coords="191,113,162,128,155,163,159,210,194,211,203,185,216,182,208,147,204,129">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=320273');return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','320273','b20', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','320273','b20', 'hidden')" shape="POLY" coords="100,242,66,193,62,179,91,172,99,155,118,192,132,202,128,217,112,228">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=54521'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','54521' ,'b21', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','54521' ,'b21', 'hidden')" shape="POLY" coords="468,177,483,155,462,136,497,113,523,123,551,112,575,132,568,168,521,206">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=67084'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','67084' ,'b22', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','67084' ,'b22', 'hidden')" shape="POLY" coords="403,261,421,209,467,183,518,207,537,231,521,249,491,232,459,240,467,262,428,268">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=00000'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b23', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','00000' ,'b23', 'visible')" shape="POLY" coords="532,201,564,170,587,190,591,210,618,235,596,261,593,280,559,291,546,278,556,265,530,246,543,226">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=73198'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','73198' ,'b24', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','73198' ,'b24', 'hidden')" shape="POLY" coords="104,246,121,219,134,208,164,214,197,209,200,218,173,222,148,238,116,242">
<area <?php if ($this->_tpl_vars['aAuthUser']): ?>onclick=""<?php else: ?>onclick="xajax_process_browse_url('?action=user_change_region&id_region=59488'); return false;"<?php endif; ?>  onfocus="this.blur()" onmouseover="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','59488' ,'b25', 'visible')" onmouseout="switchMap('<?php echo $this->_tpl_vars['sCityByIp']; ?>
','59488' ,'b25', 'hidden')" shape="POLY" coords="316,71,328,36,402,22,400,62,394,112,369,117,325,99,314,85">

</map>
<div id="load_map" align="center">
 <div id="b0"><img src="/imgbank/Image/obl/map1_new.png" width="664" height="454" border="0"></div>
 <div id="b1"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 49713): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/kievs.png"     height="128" alt=""></div>
 <div id="b2"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 64380): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/cherkas.png"   height="98" alt=""></div>
 <div id="b3"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 50345): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/lviv.png"      height="98" alt=""></div>
 <div id="b4"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 4): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/zakarp.png"    height="69" alt=""></div>
 <div id="b5"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 66015): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/zhitom.png"    height="113" alt=""></div>
 <div id="b6"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 151304): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/zaporozh.png"  height="100" alt=""></div>
 <div id="b7"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 55491): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/volyn.png"     height="89" alt=""></div>
 <div id="b8"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 103567): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/vinnic.png"    height="100" alt=""></div>
 <div id="b9"  style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 52284): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/ternop.png"    height="94" alt=""></div>
 <div id="b10" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 59307): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/sumsk.png"     height="120" alt=""></div>
 <div id="b11" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 172664): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/roven.png"     height="104" alt=""></div>
 <div id="b12" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 172659): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/poltav.png"    height="95" alt=""></div>
 <div id="b13" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 29790): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/odess.png"     height="157" alt=""></div>
 <div id="b14" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 63132): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/nikolaev.png"  height="86" alt=""></div>
 <div id="b15" style="visibility: visible;"><img src="/imgbank/Image/obl/lugansk.png"   height="115" alt=""></div>
 <div id="b16" style="visibility: visible;"><img src="/imgbank/Image/obl/krymsk.png"    height="98" alt=""></div>
 <div id="b17" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 55912): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/kirovog.png"   height="82" alt=""></div>
 <div id="b18" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 30608): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/kherson.png"   height="82" alt=""></div>
 <div id="b19" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 286985): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/khmelnic.png"  height="112" alt=""></div>
 <div id="b20" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 320273): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/iv_fran.png"   height="96" alt=""></div>
 <div id="b21" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 54521): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/kharkov.png"   height="107" alt=""></div>
 <div id="b22" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 67084): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/dneprop.png"   height="93" alt=""></div>
 <div id="b23" style="visibility: visible;"><img src="/imgbank/Image/obl/doneck.png"    height="127" alt=""></div>
 <div id="b24" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 73198): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/chernovic.png" height="48" alt=""></div>
 <div id="b25" style="visibility: <?php if ($this->_tpl_vars['sCityByIp'] == 59488): ?>visible<?php else: ?>hidden<?php endif; ?>;"><img src="/imgbank/Image/obl/chernigov.png" height="110" alt=""></div>
 <div id="b01"><img src="/imgbank/Image/obl/map_text.png" width="664" height="454" alt=""></div>
 <div id="b00"><img src="/imgbank/Image/obl/shadow.gif" width="664" height="454" alt="" usemap="#regions_map"></div>
 <div id="obl" style="display:none;"></div>
</div>-->



<div class="wrap-right">
            <div class="contacts">
                <div class="adress" >
                    <?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:project_address'); ?>

                    <br>
                    <?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:email_from'); ?>

                    <br>
                    
                </div>
                <div class="phones">
                    <?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:project_phone'); ?>
<br />
                    
                                    </div>
            </div>
        </div>
        <div class="wrap-left" id="center_column" >
        <?php echo $this->_tpl_vars['sContactForm']; ?>

            
        </div>
        <div class="clear"></div>

        <div class="wrap-map" style="text-align: center;">
			        </div>
        
            <script type='text/javascript'>
    $('.gm-block-page').addClass('gm-block-contacts');
</script>