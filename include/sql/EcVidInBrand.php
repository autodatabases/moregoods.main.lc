<?
function SqlEcVidInBrandCall($aData)
{
	$sWhere.=$aData['where'];

	Db::SetWhere($sWhere,$aData,'id_brand_group','big');
	Db::SetWhere($sWhere,$aData,'id_brand','big');
	
	if($aData['id_region']) {
	    $sJoin.=" inner join ec_brand_in_region as bir on bir.id_brand=b.id and bir.id_region='".$aData['id_region']."' ";
	}
	
	$sSql="select v.*, big.id_brand_group, big.id_brand
			from ec_products as p
	        inner join ec_product_in_vid as piv on piv.id_product=p.id
	        inner join ec_vid as v on v.id=piv.id_vid
	        inner join ec_brand_in_group as big on big.id_brand=p.id_brand
	        inner join ec_brand_group as bg on bg.id=big.id_brand_group and p.id_brand_group=bg.id
	        inner join ec_brand as b on p.id_brand=b.id

	        inner join ec_price as pr on pr.id_product=p.id
	        inner join ec_region as r on r.id=pr.id_region
	        inner join ec_distributor_region as dr on dr.id_region=r.id
	        inner join ec_distributor as d on d.id=dr.id_distributor
	        inner join ec_stock as s on s.id_region=r.id and s.id_distributor=d.id and s.id_product=p.id

			".$sJoin."
			where 1=1
				".$sWhere."
			group by v.id";

	return $sSql;
}
?>