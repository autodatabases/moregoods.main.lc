{$oLanguage->GetText('home_top_line')}
<script type="text/javascript" src="/libp/jquery/jquery.idTabs.min.js"></script>
<table><tr><td>
<ul class="idTabs" valign="bottom"> 
  <li><a class="selected" href="#search_vehicle">{$oLanguage->getMessage('search vehicle')}</a></li> 
  <li><a href="#search_typemines">{$oLanguage->getMessage('search typemines')}</a></li> 
</ul>
</td>
<td>
<div id="search_vehicle" class="form" style="width: 500px;" align="left">
<div class="cut1"><div class="cut2"><div class="cut3"><div class="cut4">
{ include file="catalog/form_index_catalog.tpl" }
</div></div></div></div>
</div>
<div id="search_typemines" class="form" style="width: 500px;" align="left">
<div class="cut1"><div class="cut2"><div class="cut3"><div class="cut4">
{ include file="catalog/form_index_type.tpl" }
</div></div></div></div>
</div>
</td>
</tr>
</table>
{literal}
<style type="text/css" media="screen">
#slider1 {
    width: 720px; /* important to be same as image width */
    height: 300px; /* important to be same as image height */
    position: relative; /* important */
	overflow: hidden; /* important */
}
#slider1Content {
    width: 720px; /* important to be same as image width or wider */
    position: absolute;
	top: 0;
	margin-left: 0;
}
.slider1Image {
    float: left;
    position: relative;
	display: none;
}
.slider1Image span {
    position: absolute;
	font: 10px/15px Arial, Helvetica, sans-serif;
    padding: 10px 13px;
    width: 694px;
    background-color: #000;
    filter: alpha(opacity=70);
    -moz-opacity: 0.7;
	-khtml-opacity: 0.7;
    opacity: 0.7;
    color: #fff;
    display: none;
}
.clear {
	clear: both;
}
.slider1Image span strong {
    font-size: 14px;
}
.left {
	top: 0;
    left: 0;
	width: 110px !important;
	height: 280px;
}
.right {
	right: 0;
	bottom: 0;
	width: 0px !important;
	height: 22px;
}
ul { list-style-type: none;}
</style>
<!-- JavaScripts-->
<script type="text/javascript" src="/libp/jquery/jquery.s3Slider.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slider1').s3Slider({
            timeOut: 4000 
        });
    });
</script>
{/literal}