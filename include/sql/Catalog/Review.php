<?
function SqlCatalogReviewCall($aData) {
	
	if ($aData['reference']) 
	{
		$sWhere.=" and reference = '".$aData['reference']."'";
	}
	if ($aData['id']) 
	{
		$sWhere.=" and r.id = '".$aData['id']."'";
	}
	if (!$aData['all']) 
	{
		$sWhere.=" and r.visible = 1";
	}
	if ($aData['order']) 
	{
		$sOrder=" order by ".$aData['order'];
	}else{
		$sOrder=" order by if(parent_id=0,r.id,parent_id),r.id";
	}
	
	$sSql="select r.*,COALESCE(r.name,uc.name,um.name,'Не указано') name, u.type_ as type, rc.stars * 20 as stars
    from review r
    left join user_customer uc on uc.id_user=r.id_user
    left join user_manager um on um.id_user=r.id_user
    left join user u on u.id = r.id_user
    left join rating_catalog as rc on rc.item_code = r.reference and rc.id_user = r.id_user
    where 1=1 
    ".$sWhere.
	$sOrder;

	return $sSql;
}
?>