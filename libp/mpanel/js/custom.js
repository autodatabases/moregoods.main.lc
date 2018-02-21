//
// Parse document elem by id 
// @return array [key] [value]
//
function parseInput(findElemId){
	var aPd = new Array();
	var elements = document.getElementsByName(findElemId);
	if (elements){
		var elemCnt = elements.length;
		for (var i = 0; i < elemCnt; i++){
			aPd[elements[i].id] = elements[i].value;
		}
	}
	
	return aPd;
}