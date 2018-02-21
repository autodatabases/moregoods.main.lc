<?
function SqlPriceCall($aData)
{
    $aData['where']=str_replace("AND pgs.id_price_group LIKE '%0%'", "and pgs.id_price_group is null", $aData['where']);
	$sWhere.=$aData['where'];
	
	Db::SetWhere($sWhere,$aData,'id','price');
	Db::SetWhere($sWhere,$aData,'id_provider','price');
	Db::SetWhere($sWhere,$aData,'code','price');
	Db::SetWhere($sWhere,$aData,'price','price');
	Db::SetWhere($sWhere,$aData,'part_rus','price');
	Db::SetWhere($sWhere,$aData,'pref','price');
	Db::SetWhere($sWhere,$aData,'cat','price');
	
	if ($aData['join']) {
		$sJoin .= " ".$aData['join'];
	}

	if ($aData['order']) {
		$sOrder.=" order by ".$aData['order'];
	}
	
	if(isset($aData['id_price_group'])) {
	    if($aData['id_price_group']==0) $sWhere.=" and pgs.id_price_group is null ";
	    else $sWhere.=" and pgs.id_price_group='".$aData['id_price_group']."' ";
	}

	$sSql="select price.*, pgs.id_price_group
			from price as price
			left join price_group_assign as pgs on pgs.item_code=price.item_code
			".$sJoin."
			where 1=1
			".$sWhere."
			group by price.id
			".$sOrder;


	return $sSql;
}
?>
