<?
function SqlAssocAccountCall($aData)
{
	if ($aData['order']) {
		$sOrder=$aData['order'];
	} else {
		$sOrder=" order by a.name ";
	}

	if ($aData['multiple']) {
		$sField.=", a.*";
	}
	if ($aData['visible']) {
		$sWhere.=" and a.visible='".$aData['visible']."'";
	}

	$sSql="select a.id , a.title
		".$sField."
	from account as a
	where 1=1
	".$sWhere
	.$sOrder;

	return $sSql;
}
?>