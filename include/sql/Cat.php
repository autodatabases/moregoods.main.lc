<?
function SqlCatCall($aData) {

	$sWhere.=$aData['where'];
	
	Db::SetWhere($sWhere,$aData,'id','c');
	Db::SetWhere($sWhere,$aData,'pref','c');
	Db::SetWhere($sWhere,$aData,'is_main','c');
	Db::SetWhere($sWhere,$aData,'is_brand','c');
	Db::SetWhere($sWhere,$aData,'visible','c');
	Db::SetWhere($sWhere,$aData,'id_tof','c');
	Db::SetWhere($sWhere,$aData,'id_sync','c');

	if ($aData['join']) {
		$sJoin .= " ".$aData['join'];
	}

	if ($aData['order']) {
		$sOrder.=" order by ".$aData['order'];
	}
	
	if($aData['id_region']) {
	    $sWhere.=" and cr.id_region='".$aData['id_region']."' ";
	    $sJoin.=" inner join cat_region as cr on c.id=cr.id_cat ";
	}

	$sSql="select c.*
			from cat as c
			".$sJoin."
			where 1=1
			".$sWhere."
			group by c.id
			".$sOrder;

	return $sSql;
}
?>