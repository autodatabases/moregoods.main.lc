//-----------------------------------------------------------------------------
function OpenFileBrowser( url, width, height )
{
	// oEditor must be defined.

	var iLeft = 200; //( oEditor.FCKConfig.ScreenWidth  - width ) / 2 ;
	var iTop  = 200; //( oEditor.FCKConfig.ScreenHeight - height ) / 2 ;

	var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
	sOptions += ",width=" + width ;
	sOptions += ",height=" + height ;
	sOptions += ",left=" + iLeft ;
	sOptions += ",top=" + iTop ;
	window.open( url, 'FCKBrowseWindow', sOptions ) ;
}
//-----------------------------------------------------------------------------
function ChangeImageURL( return_id, url )
{
	var image=document.getElementById(return_id);
	image.width=100;
	document.getElementById(return_id).src=url;
	//image_input=document.forms['main_form'].elements[return_id];
	image_input=document.getElementById(return_id+'_input');
	image_input.value=url;
}

//-----------------------------------------------------------------------------
function ClearImageURL( return_id )
{
	var image=document.getElementById(return_id);
	image.width=0;
	image.src=null;
	//image_input=document.forms['main_form'].elements[return_id+'_input'];
	image_input=document.getElementById(return_id+'_input');
	image_input.value='';
}
//-----------------------------------------------------------------------------
//
// Load JavaScript
//
function LoadScript(sId, sSsource, iRewrite){
	var head = document.getElementsByTagName("head")[0];
	var script = document.getElementById(sId);
	if (script){
	  if ((typeof(iRewrite)!='undefined')&&(iRewrite>0)) {
	    head.removeChild(script);
	  }
 	  else return;
	}
	script=document.createElement('script');
	script.id=sId;
	script.type='text/javascript';
	script.src=sSsource;
	head.appendChild(script);
}
//-----------------------------------------------------------------------------
function GetElementPosition(elemId)
{
	if (typeof(elemId) == 'string')   { elem = document.getElementById(elemId); }
	else { elem = elemId; }

    var w = elem.offsetWidth;
    var h = elem.offsetHeight;

    var l = 0;
    var t = 0;

    while (elem)
    {
        l += elem.offsetLeft;
        t += elem.offsetTop;
        elem = elem.offsetParent;
    }

    return {"left":l, "top":t, "width": w, "height":h};
}
//-----------------------------------------------------------------------------
function StartUploadProgress(baseId){
	 document.getElementById('divInput'+baseId).style.display  = 'none';

	 progress = document.getElementById('progress'+baseId);
     progress.style.display = 'block';
     progress.style.top = -15;

     return true;
}
//-----------------------------------------------------------------------------
function ShowHideUpload(baseId,show) {
      StopUploadProgress(baseId);
      var divForm = document.getElementById('divForm'+baseId);
	  if(show)
	       { divForm.className = 'upload_show'; }
	  else {
	      divForm.className = 'upload_hide';
          msg = document.getElementById('divMsg'+baseId);
          msg.innerHTML =  '';
          msg.style.display = 'block';
	  }
}
//-----------------------------------------------------------------------------
function StopUploadProgress(baseId){
      document.getElementById('divInput'+baseId).style.display = 'block';
      document.getElementById('progress'+baseId).style.display = 'none';
      return true;
}
//-----------------------------------------------------------------------------
function StopUpload(baseId, fileName, sError, OriginalFileName){
    if (sError) {
      StopUploadProgress(baseId);
      msg = document.getElementById('divMsg'+baseId);
      msg.innerHTML =  sError;
      msg.style.display = 'block';

      RedrawFormUpload(baseId);
    }
    else
    {
      if (fileName){
          var inputHidden = document.getElementById('inputHidden'+baseId);
          if (inputHidden) { inputHidden.value = fileName; }

          var imageFile = document.getElementById('image'+baseId);
          if (imageFile) { imageFile.src = '/libp/mpanel/images/document_check.png'; }
      }
      if (OriginalFileName) {
          var inputHiddenOriginal = document.getElementById('inputHiddenOriginal'+baseId);
          if (inputHiddenOriginal) { inputHiddenOriginal.value = OriginalFileName;}
          var filenameoriginal = document.getElementById('filenameoriginal'+baseId);
          if (filenameoriginal) { filenameoriginal.innerHTML = OriginalFileName;}
      }

      ShowHideUpload(baseId,false);
    }
    return true;
}
//-----------------------------------------------------------------------------
function ResetInputUpload(baseId) {
    divInput = document.getElementById('divInput'+baseId);
	divInput.innerHTML=
	  '<input onchange="document.getElementById(\''+'submit'+baseId+'\').click();" name="input_file" type="file">';
}
//-----------------------------------------------------------------------------
function RedrawFormUpload(baseId) {
    var image_file = document.getElementById('image'+baseId);
    var pos = GetElementPosition(image_file);
    var divForm = document.getElementById('divForm'+baseId);
    divForm.style.left =  pos.left + pos.width + 10;
    divForm.style.top =  pos.top + pos.height - divForm.offsetHeight;
}
//-----------------------------------------------------------------------------
function ShowFileUpload(baseId, show)
{
    if(show)
    {
        ResetInputUpload(baseId);
        ShowHideUpload(baseId,true);
        RedrawFormUpload(baseId);
    }
    else
    {
        var inputHidden = document.getElementById('inputHidden'+baseId);
        if  (inputHidden) { inputHidden.value = ''; }
        var inputHiddenOriginal = document.getElementById('inputHiddenOriginal'+baseId);
        if  (inputHiddenOriginal) { inputHiddenOriginal.value = ''; }
        var imageFile = document.getElementById('image'+baseId);
        if (imageFile) { imageFile.src = 'images/document.png'; }
        var filenameoriginal = document.getElementById('filenameoriginal'+baseId);
        if (filenameoriginal) { filenameoriginal.innerHTML = '';}
        
        ShowHideUpload(baseId,false);
    }
}
//-----------------------------------------------------------------------------
