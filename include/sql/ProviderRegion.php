<?
function SqlProviderRegionCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and pr.id='".$aData['id']."'";
	}
//	if ($aData['join_manager']) {
//		$sJoin.=" left join user_manager_region as umr on (umr.id_provider_region=pr.id and umr.id_user='".$aData['id_user']."')";
//		$sField.=" , umr.id_user as region_allowed";
//	}

	$sSql="select pr.*, ofr.name as region, ofc.name as city
				".$sField."
			from provider_region pr
			left join office_region as ofr on pr.id_region=ofr.id
			left join office_city as ofc on pr.id_city=ofc.id
				".$sJoin."
			where 1=1
				".$sWhere."
			group by pr.id";

	return $sSql;
}
?>