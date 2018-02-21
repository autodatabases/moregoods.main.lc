var ColorTable=function () {
	this.checkBoxAllId = "all";
	this.evenClass = "even";
	this.noneClass = "none";
	this.tableClass = "itemslist";
};

ColorTable.prototype.AddClass = function (element,value) {
	if (!element.className) {
		element.className = value;
	} else {
		newClassName = element.className;
		newClassName+= " ";
		newClassName+= value;
		element.className = newClassName;
	}
}


ColorTable.prototype.StripeTables = function () {
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].classList.contains(this.tableClass)) {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var i=0; i<tbodies.length; i++) {
				var odd = true;
				var rows = tbodies[i].getElementsByTagName("tr");
				for (var j=0; j<rows.length; j++) {
					if (odd == false) {
						odd = true;
					} else {
						oColorTable.AddClass(rows[j],"");
						odd = false;
					}
				}
			}
		}
	}
}

ColorTable.prototype.HighlightRows = function(){
	if(!document.getElementsByTagName) return false;
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].classList.contains(this.tableClass)) {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var j=0; j<tbodies.length; j++) {
				var rows = tbodies[j].getElementsByTagName("tr");
				for (var i=0; i<rows.length; i++) {
					rows[i].className=rows[i].className.replace(' ','')
					if (rows[i].className == this.evenClass || rows[i].className == this.noneClass){
						rows[i].oldClassName = rows[i].className
						rows[i].onmouseover = function() {
							if( this.className.indexOf("selected") == -1)
							oColorTable.AddClass(this,"highlight");
						}
						rows[i].onmouseout = function() {
							if( this.className.indexOf("selected") == -1)
							this.className = this.oldClassName
						}
					}
				}
			}
		}
	}
}

ColorTable.prototype.SelectRowCheckbox = function (row) {
	var checkbox = row.getElementsByTagName("input")[0];

	if (checkbox.checked == true) {
		checkbox.checked = false;
	} else
	if (checkbox.checked == false) {
		checkbox.checked = true;
	}
}

ColorTable.prototype.LockRow = function(){
	var checkboxAll = document.getElementById(this.checkBoxAllId);
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].classList.contains(this.tableClass)) {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var j=0; j<tbodies.length; j++) {
				var rows = tbodies[j].getElementsByTagName("tr");
				for (var i=0; i<rows.length; i++) {
					rows[i].oldClassName = rows[i].className;
					var checkbox = rows[i].getElementsByTagName("input")[0];
					if (checkbox == null || checkboxAll==null)
						return;
						rows[i].className=rows[i].className.replace(' ','')
						if (rows[i].className == this.evenClass || rows[i].className == this.noneClass){
						rows[i].onclick = function() {
							if (this.className.indexOf("selected") != -1) {
								this.className = this.oldClassName;
							} else {
								oColorTable.AddClass(this,"selected");
							}
							oColorTable.SelectRowCheckbox(this);
						}
					}

				}
			}
		}
	}
}

/**
*  Change selection for all checkboxes
*  @param boolean stat - tell about new status for checkboxes
**/
ColorTable.prototype.SelectAll = function(stat){
	var checkboxAll = document.getElementById(this.checkBoxAllId);
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].classList.contains(this.tableClass)) {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var j=0; j<tbodies.length; j++) {
				var rows = tbodies[j].getElementsByTagName("tr");
				for (var i=0; i<rows.length; i++) {
					var checkbox = rows[i].getElementsByTagName("input")[0];
					if (checkbox){
						checkbox.checked = stat;
					}
					if (stat && checkbox != checkboxAll){
						rows[i].className=rows[i].className.replace(' ','')
						if (rows[i].className == this.evenClass || rows[i].className == this.noneClass){
							oColorTable.AddClass(rows[i],"selected");
						}
					}else{
						rows[i].className = rows[i].oldClassName;
					}
				}
			}
		}
	}
}

ColorTable.prototype.LockRowUsingCheckbox = function() {
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].classList.contains(this.tableClass)) {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var j=0; j<tbodies.length; j++) {

				var checkboxes = tbodies[j].getElementsByTagName("input");
				for (var i=0; i<checkboxes.length; i++) {
					checkboxes[i].onclick = function(evt) {
						if (this.parentNode.parentNode.className.indexOf("selected") != -1){
							this.parentNode.parentNode.className = this.parentNode.parentNode.oldClassName;
						} else {
							oColorTable.AddClass(this.parentNode.parentNode,"selected");
						}
						if (window.event && !window.event.cancelBubble) {
							window.event.cancelBubble = "true";
						} else {
							evt.stopPropagation();
						}
					}
				}
			}
		}
	}
}

/**
* Set up onClick action for checkbox with id='all'
**/
ColorTable.prototype.SetUpChekAll = function(){
	var checkboxAll = document.getElementById(this.checkBoxAllId);
	checkboxAll.onclick = function() {
		oColorTable.SelectAll(this.checked);
	}
}


var oColorTable = new ColorTable();