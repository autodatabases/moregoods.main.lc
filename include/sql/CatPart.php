<?
function SqlCatPartCall($aData)
{
	$sWhere.=$aData['where'];

	if ($aData['id']) {
		$sWhere.=" and cp.id='{$aData['id']}'";
	}

	if ($aData['pref']) {
		$sWhere.=" and cp.pref='{$aData['pref']}'";
	}

	if ($aData['code']) {
		$sWhere.=" and cp.code='{$aData['code']}'";
	}
	
	if ($aData['item_code']) {
		$sWhere.=" and cp.item_code='".$aData['item_code']."'";
	}

	if ($aData['weight_log']) {
		$sField=" , cpw.weight as cpw_weight , cpw.post_date as cpw_post_date, cpw.name_rus as cpw_name_rus
					, cpw.comment as cpw_comment
					, u.login as u_login ";
		$sJoin=" inner join cat_part_weight as cpw on cp.id=cpw.id_cat_part
				 inner join user as u on cpw.id_user=u.id
		";

		if ($aData['comment']) {
			$sWhere.=" and cpw.comment like '%".$aData['comment']."%'";
		}
	}

	$sSql="select cp.*, cp.id as id_cat_part
		".$sField."
	from cat_part as cp
		".$sJoin."
	where 1=1
		".$sWhere
	;

	return $sSql;
}
?>