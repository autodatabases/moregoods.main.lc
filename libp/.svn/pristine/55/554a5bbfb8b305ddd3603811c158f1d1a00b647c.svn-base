function dg(id) {
	return document.getElementById(id);
}

var Mpanel=function (data) {
	//this.data=data;
};


Mpanel.prototype.ToggleElement = function (sId)
{
	if (!dg(sId)) return;

	if(dg(sId).style.display=='none' )  {
		dg(sId).style.display = '';
	}
	else {
		dg(sId).style.display = 'none';
	}
};

var oMpanel=new Mpanel();
