{* <script type="text/javascript" src="/libp/mpanel/dtree/dtree.js"></script> *}
{* include file=catalog/tree_icon.tpl *} 
{ include file=catalog/navigator.tpl }<br>

<div class="tree-assemblage-table">
	{if $bRightPartCatalog}
	<div class="right-col">
		<h4>{$oLanguage->GetMessage('choose parts')}</h4>
		<script>
		  $(document).ready(function(){ldelim}
		     $("#sort").change(function () {ldelim}
		          var str = "sort=";
		          $("#sort option:selected").each(function () {ldelim}
		                str += $(this).val();
		          {rdelim});
		     location.href='{$sUrl}'+str+'/';
		     {rdelim});
		  {rdelim});
		</script>
		
		<link rel="stylesheet" property="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="/libp/jquery/jquery.thickbox.js"></script>
		
		<!--select id="sort" name="sOrderPrice" style="width: 120px;">
				<option value="price" {if $smarty.request.data.sort=="price"} selected {/if}>{$oLanguage->GetMessage('sort by price')}</option>
				<option value="brand" {if $smarty.request.data.sort=="brand"} selected {/if}>{$oLanguage->GetMessage('sort by brand')}</option>
		</select-->
		
		{$sTablePrice}
	</div>
	{/if}
	<div class="left-col">
			{include file=catalog/form_own_auto.tpl}

			<h4>{$oLanguage->GetMessage('choose group parts')}</h4>
			<!--<select class="floatR" style="width: 160px;"><option>����� ������ ���������</option></select>-->
			
	
			<div class="dtree_hd">
			{if $smarty.request.data.id_group_icon}<img src="{$sTreeIconSel}"><br><br>{/if}
	        
	        {assign var="sNameTree" value="d2"}		
			
			<a href="javascript: {$sNameTree}.openAll();"><img src="/libp/mpanel/images/dtree/expandall.png" alt="" /></a>
			<a href="javascript: {$sNameTree}.closeAll();"><img src="/libp/mpanel/images/dtree/collapseall.png" alt="" /></a>
	                
			</div>
			<script type="text/javascript">
			//add(id, pid, name, url, title, target, icon, iconOpen, open, javascript)
	                
			{$sNameTree} = new dTree('{$sNameTree}');
	                
	                {* ALT-587 *}
	                // for seourl and save selected tree added this parameter
	                {$sNameTree}.config.cookiePath=true;
	                {* ALT-587 *}
	                    
			//d.config.folderLinks=true;
			{$sNameTree}.config.useIcons=false;
			//d.config.useLines=false;
			{$sNameTree}.config.useSelection=true;
			//d.config.useStatusText=true;
			//d.config.closeSameLevel=true;
	
			//d.icon.plus='/image/design/plus.gif';
			//d.icon.plusBottom='/image/design/plus.gif';
			//d.icon.minus='/image/design/minus.gif';
			//d.icon.minusBottom='/image/design/minus.gif';
			//d.icon.line='/image/design/line.gif';
			//d.icon.join='/image/design/join.gif';
			//d.icon.joinBottom='/image/design/joinbottom.gif';
	
			{if !$smarty.request.data.id_part}{$sNameTree}.clearCookie();{/if}
	                   
	    
			{$sNameTree}.add(10001,-1,'&nbsp;');//{$oLanguage->GetMessage('assemblage')}
			{foreach key=key item=aValue from=$aTree}
	                    {$sNameTree}.add({$aValue.id},{$aValue.str_id_parent},'{$aValue.data|escape}','{if $aValue.seourl}{$aValue.seourl}{else}/?action=catalog_part_view&data[id_make]={$smarty.request.data.id_make}&data[id_model]={$smarty.request.data.id_model}&data[id_model_detail]={$smarty.request.data.id_model_detail}&data[id_part]={$aValue.id}&data[sort]={$smarty.request.data.sort}{/if}','{$aValue.data|escape}','','','','','');
	                    {if $aValue.id == $smarty.request.data.id_part}
	                        {if $sNeed_aCod != 'none'}
	                            {if $sNeed_aCod == 'replace'}
	                                {$sNameTree}.setCookie('co' + '{$sNameTree}', '');
	                            {/if}                                
	                            {if (count($aCod) > 0)}
	                                {foreach key=keyCookie item=aValueCookie from=$aCod}
	                                    {$sNameTree}.updateIfNeedCookie('co' + '{$sNameTree}','{$aValueCookie}');
	                                {/foreach}
	                            {/if}
	                            {$sNameTree}.setCookie('cs' + '{$sNameTree}', {$aValue.id});
	                        {/if}
	                    {/if}
	                {/foreach}
			
			document.write({$sNameTree});
			
			{if $smarty.request.data.id_group_icon}{$sNameTree}.openAll();{/if}
			</script>
	</div>

</div>