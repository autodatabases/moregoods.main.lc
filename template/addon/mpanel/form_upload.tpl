<div id="divForm{$sBaseUpload}" class="upload_hide">
	<form id="form{$sBaseUpload}" action="{$sFormAction}" onsubmit="javascript:StartUploadProgress('{$sBaseUpload}')" method="post"
				enctype="multipart/form-data" target="iframe{$sBaseUpload}" style="font-size:0;">
	   <input id="submit{$sBaseUpload}" type="submit" style="display:none;" />
       <div id="progress{$sBaseUpload}" class="upload_progress">Loading...<br/><img src="/libp/mpanel/images/loader.gif" /></div>
       <div id="divMsg{$sBaseUpload}" class="upload_message"></div>
	   <div id="divInput{$sBaseUpload}" ></div>
	</form>
	<iframe name="iframe{$sBaseUpload}" style="display: none;"></iframe>
</div>
