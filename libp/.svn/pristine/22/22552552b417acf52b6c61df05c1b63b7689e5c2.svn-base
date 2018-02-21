function createRequestObject() {
	var obj;
	var browser = navigator.appName;

	if(browser == "Microsoft Internet Explorer"){
		obj = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else{
		obj = new XMLHttpRequest();
	}
	return obj;
}

function traceUpload(uploadDir,uploader_name)
{
	http.onreadystatechange = handleResponse;
	http.open("GET", 'uploader_csv.php?uploadDir='+uploadDir+'&uploader='+uploader);
	http.send(null);
}

function handleResponse()
{
	if(http.readyState == 4){
		document.getElementById(uploaderId).innerHTML = http.responseText;
		//window.location.reload(true);
	}
	else {
		document.getElementById(uploaderId).innerHTML = "Uploading File. Please wait...";
	}
}

function uploadFile(obj,uploader_name)
{
	var uploadDir = obj.value;
	uploaderId = 'uploader'+obj.name;
	uploader = obj.name;

	document.getElementById('formName'+obj.name).submit();
	traceUpload(uploadDir,uploader_name);
}