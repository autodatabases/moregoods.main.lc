<?
function SqlModelPicCall($aData) {

	$sWhere.=$aData['where'];

	Db::SetWhere($sWhere,$aData,'id','mp','id');
	Db::SetWhere($sWhere,$aData,'id_model','mp');
	if(!$aData['bNoTecdocName']){
		/*$sJoin="
			inner join cat as c on c.id=mp.id_make
			inner join ".DB_TOF."tof__models m on mod_id=mp.id_model
			left outer join ".DB_TOF."tof__country_designations uni_des
			on mod_cds_id = uni_des.cds_id
			and uni_des.cds_lng_id = @lng_id
			and substring(uni_des.cds_ctm, @cou_id,1) = 1 

			left outer join ".DB_TOF."tof__des_texts uni_tex
			on uni_des.cds_tex_id = uni_tex.tex_id   

			left outer join ".DB_TOF."tof__country_designations lng_des
			on mod_cds_id = lng_des.cds_id
			and lng_des.cds_lng_id = @lng_id
			and substring(lng_des.cds_ctm, @cou_id,1) = 1

			left outer join ".DB_TOF."tof__des_texts lng_tex
			on lng_des.cds_tex_id = lng_tex.tex_id";
		$sField.=",c.title as make,ifnull(lng_tex.tex_text, uni_tex.tex_text) as model";
		*/
/*		$sJoin="
			inner join cat as c on c.id_tof=mp.id_tof
			inner join ".DB_OCAT."cat_alt_models ca ON ca.ID_src=mp.id_model
			";
		$sField.=",c.title as make,ca.Name as model";*/
	}

	$sSql="select mp.*".$sField."
			from model_pic as mp
			".$sJoin."
			where 1=1 ".$sWhere."
			group by mp.id";

	return $sSql;
}
?>