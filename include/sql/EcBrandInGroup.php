<?
function SqlEcBrandInGroupCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and bigr.id='".$aData['id']."'";
	}
	Db::SetWhere($sWhere,$aData,'id_brand_group','bigr');
	
	if($aData['id_region']) {
	    $sJoin.=" inner join ec_brand_in_region as bir on bir.id_brand=b.id and bir.id_region='".$aData['id_region']."' ";
	}

	$sSql="select bigr.* , b.name as brand, bg.name as brand_group, b.id as id_brand
			from ec_brand_in_group bigr
			left join ec_brand_group as bg on bigr.id_brand_group=bg.id
			left join ec_brand as b on bigr.id_brand=b.id
	    ".$sJoin."
			where 1=1
				".$sWhere."
			group by bigr.id";

	return $sSql;
}
?>