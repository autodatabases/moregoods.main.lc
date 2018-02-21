var MstarForm=function (data) {
	//this.data=data;
};

// need /libp/jquery/jquery.min.js
MstarForm.prototype.SetFocus = function (id_element)
{
	$("#"+id_element)[0].focus();
}

// need /libp/jquery/jquery.min.js
MstarForm.prototype.Location = function(sAction,aId)
{
	var sAdd="";
	//alert(sAction);
	//var sss="";
	//if ($("#cart_notconfirm:checked").val()==1) {sss=1}
	//sUrl=$("#code").text();
	for (key in aId) {
		if (key%2==0) {
			sAdd=sAdd+"&"+aId[key]+"=";
		} else {
			sAdd=sAdd+$("#"+aId[key]).val();
		}
	}
	location.href=sAction+sAdd;
}

MstarForm.prototype.InitPrint = function (sHeader,sFooter, bPortrait, leftMargin, topMargin, rightMargin, bottomMargin, bPrint)
{
	if (!factory.object) {
		return
	} else {
		factory.printing.header = sHeader;
		factory.printing.footer = sFooter;
		factory.printing.portrait = bPortrait;
		factory.printing.leftMargin = leftMargin;
		factory.printing.topMargin = topMargin;
		factory.printing.rightMargin = rightMargin;
		factory.printing.bottomMargin = bottomMargin;
		//factory.printing.Print(bPrint);

	}
}

MstarForm.prototype.SetFocusOnEnter = function (event, idFocus)
{
	if(event.keyCode==13){
		mf.SetFocus(idFocus);
		return true;
	}
	return false;
}

MstarForm.prototype.BlockEnterIf = function (evt,aId)
{
	evt = (evt) ? evt : event;
	var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
	
	for (key in aId) {
		if (key%2==0) {
			sValue1=$("#"+aId[key]).val();
		} else {
			sValue2=aId[key];
			
			if ((sValue1=='----' || sValue1==sValue2)&& charCode == 13) {
				return false;
			} else {
				return true;
			}
		}
	}
}

var mf=new MstarForm();
