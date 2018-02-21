<link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/libp/jquery/jquery.thickbox.js"></script>
<table style="width:99%;">
<tr>
	<td>
<div id="upload{$aData.id}" ><span><b>{$oLanguage->getMessage('add image')}</b><img src="/image/attach.png"><span></div>
<div id="mainbody" >
		<!-- Upload Button, use any id you wish-->
		<span id="status" ></span>
</div>
<span id="files{$aData.id}" >
{if $aGraphic}
{foreach key=key item=item from=$aGraphic}
<a class="thickbox" href="{$item.img_path}"><img src="{$item.img_path}" width="150px"></a>
{if $item.id_cat_part}<a href="http://{$smarty.server.SERVER_NAME}/?action=catalog_manager_delete_pic&id={$item.id_cat_pic}&return={$sReturn|escape:"url"}"
		><img src="/image/delete.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("delete")}</a>
<br>{* hide becouse incorrect work function in server - parse_url
<br>	Alt:<br> 	{include file='catalog_manager/editable_input.tpl' sTable='cat_pic' sCol='alt' sRow=id iRowId=$item.id_cat_pic sValue=$item.alt}
<br>	Title:<br> 	{include file='catalog_manager/editable_input.tpl' sTable='cat_pic' sCol='title' sRow=id iRowId=$item.id_cat_pic sValue=$item.title}
<br>	Num:<br> 	{include file='catalog_manager/editable_input.tpl' sTable='cat_pic' sCol='num' sRow=id iRowId=$item.id_cat_pic sValue=$item.num}
{else}
<br>	Alt:<br> 	{include file='catalog_manager/editable_input.tpl' sTable='cat_pic_tecdoc' sCol='alt' sRow=path iRowId=$item.img_path sValue=$item.alt}
<br>	Title:<br> 	{include file='catalog_manager/editable_input.tpl' sTable='cat_pic_tecdoc' sCol='title' sRow=path iRowId=$item.img_path sValue=$item.title}
<br>	Num:<br> 	{include file='catalog_manager/editable_input.tpl' sTable='cat_pic_tecdoc' sCol='num' sRow=path iRowId=$item.img_path sValue=$item.num}
*}
{/if}
<br><hr>
{/foreach}
{/if}
{if $aPdf}
<br>
{foreach key=key item=item from=$aPdf}
	<a target="_blank" href="{$item.img_path}">{$oLanguage->GetMessage('aditional pdf info ')}</a><br>
{/foreach}
{/if}
</span>
{*<table width="99%">
<tr>
	<td><b>{$oLanguage->getMessage("Item_code")} :</b></td>
	<td><input type="text" readonly name=data[item_code] value='{$aData.item_code}'></td>
	</tr>
<tr>
	<td><b>{$oLanguage->getMessage("tecdoc_name")} :</b></td>
	<td>{$aPartInfo.name}</td>
	</tr>
<tr>
	<td><b>{$oLanguage->getMessage("Catalog name")} :</b></td>
	<td><input type=text name=data[name_rus] value='{$aData.name_rus|escape}' maxlength=50 style='width:350px'></td>
	</tr>
</table>*}
<script type="text/javascript" src="/libp/jquery/jquery.ajaxupload.js" ></script>
<script type="text/javascript" >
$(function(){ldelim}
		var status=$('#status');
		var status_warning='Only PDF, JPG, PNG or GIF files are allowed';
		var status_process='Uploading...';
		var id_file='{ldelim}$aData.id{rdelim}';
		new AjaxUpload( $('#upload{$aData.id}'), {ldelim}
			action: '?action=catalog_manager_upload_pic&id_cat_part={$aData.id}',
			name: 'uploadfile',
			onSubmit: function(file, ext){ldelim}
				 if (! (ext && /^(jpg|png|jpeg|gif|pdf)$/.test(ext))){ldelim} 
                    // extension is not allowed 
					status.text(status_warning);
					return false;
				{rdelim}
				status.text(status_process);
			{rdelim},
			onComplete: function(file, response){ldelim}
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response>0){ldelim}
					$('<span></span>').appendTo('#files{$aData.id}').html('<a target=blaank href="/imgbank/Image/pic/'+response+'_'+file+'">'+file+'</a><br />').addClass('success');
					//$('<span></span>').appendTo('#files{$aData.id}').html('<a class="thickbox" href="/imgbank/Image/ebay/'+response+'_'+file+'"><img src="/imgbank/Image/ebay/'+response+'_'+file+' width="150px"></a><br>').addClass('success');
				{rdelim} else {ldelim}
					$('<span></span>').appendTo('#files{$aData.id}').text(file).addClass('error');
				{rdelim}
			{rdelim}
		{rdelim});
{rdelim});
</script>
</td>
	</tr>
</table>