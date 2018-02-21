<?
function SqlCatRegionCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and cr.id='".$aData['id']."'";
	}

	$sSql="select cr.*, pr.name as region, c.name as cat
				".$sField."
			from cat_region cr
			inner join provider_region as pr on cr.id_region=pr.id
			inner join cat as c on cr.id_cat=c.id
				".$sJoin."
			where 1=1
				".$sWhere."
			group by cr.id";

	return $sSql;
}
?>