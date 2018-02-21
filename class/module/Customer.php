<?

/**
 * @author Mikhail Starovoyt
 *
 */

class Customer extends Base
{
	//-----------------------------------------------------------------------------------------------
	function __construct()
	{
		Auth::NeedAuth('customer');
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		$this->Profile();
	}
	//-----------------------------------------------------------------------------------------------
	public function Profile()
	{
		Base::$bXajaxPresent=true;
		Base::$aTopPageTemplate=array('panel/tab_customer.tpl'=>'profile');

		if (Base::$aRequest['is_post']) {
			$sLanguage="update user set language='".Base::$aRequest['data']['language']."' 
			where id='".Auth::$aUser['id']."';";
			$sQuery="update user_customer set
				remark='".strip_tags(Base::$aRequest['data']['remark'])."',
				vip_remark='".strip_tags(Base::$aRequest['data']['vip_remark'])."'
			where id_user='".Auth::$aUser['id']."';";
			Base::$db->Execute($sQuery);
			Base::$db->Execute($sLanguage);
			
			if(Base::$aRequest['data']['addreses']) {
			    $aAdresses=String::FilterRequestData(Base::$aRequest['data']['addreses']);
			    if($aAdresses) {
			        Db::Execute("delete from ec_addres where id_user='".Auth::$aUser['id']."' and id not in ('".implode("','", array_keys($aAdresses))."') ");
			        foreach ($aAdresses as $iKey => $sValue) {
			            if(!$sValue) continue;
			            $bExist=Db::GetOne("select id from  ec_addres where id_user='".Auth::$aUser['id']."' and id='".$iKey."' ");

			            $aInsert=array(
			                'id_user'=>Auth::$aUser['id'],
			                'addresses'=>$sValue,
			                'visible'=>'1',
			                'post_date'=>date("Y-m-d H:i:s")
			            );
			            
			            if(!$bExist) {
    			            Db::AutoExecute('ec_addres',$aInsert);
			            } else {
			                Db::AutoExecute('ec_addres',$aInsert,"UPDATE", " id = '".$iKey."' ");
			            }
			        }
			    }
			}

			$aUserCustomer=String::FilterRequestData(Base::$aRequest['data'],array(
			'name', 'city','address','phone','remarks','id_currency'
			));
//, 'id_geo'			
//            $aUserCustomer['id_region']=Db::GetOne("select ec_region from net_city where id='".$aUserCustomer['id_geo']."'");
			Db::Autoexecute('user_customer',$aUserCustomer,'UPDATE',"id_user='".Auth::$aUser['id']."'");

			$aUser=String::FilterRequestData(Base::$aRequest['data'],array('email'));
			if (!String::CheckEmail($aUser['email'])) {
				$aUser['email']='';
				$sError.=Language::GetMessage("Not valid email and will be set to empty.");
			}
			Base::$db->Autoexecute('user',$aUser,'UPDATE',"id='".Auth::$aUser['id']."'");
			Auth::$aUser=Auth::IsUser(Auth::$aUser['login'],Auth::$aUser['password']);

			if (Auth::$aUser['has_forum']){
				Forum::ChangeProfile(Auth::$aUser);
			}
		}

		Auth::RefreshSession(Auth::$aUser);
		Auth::$aUser['amount_currency']=Base::$oCurrency->PrintPrice(Auth::$aUser['amount'],Auth::$aUser['id_currency']);

		Base::$tpl->assign('aUser',Auth::$aUser);
		Base::$tpl->assign('sManagerLogin',Base::$db->getOne("select login from user where id='".Auth::$aUser['id_manager']."'"));
		Base::$tpl->assign('sManagerName',
		Base::$db->getOne("select name from user_manager where id_user='".Auth::$aUser['id_manager']."'"));
		
		$aRegionList=Db::GetAssoc("select id, name from ec_region order by name");
		Base::$tpl->assign('aRegionList',$aRegionList);

        $aRegionGeoSelected=Db::GetOne("select name_ru from net_city where id = '".Auth::$aUser['id_geo']."'");
        Base::$tpl->assign('aRegionGeoSelected',$aRegionGeoSelected);

		$sSelectedCity=Content::GetSelectedCity();
		Base::$tpl->assign('sSelectedCity',$sSelectedCity);

        $aCity=Db::GetAssoc("select id, name_ru from net_city  order by name_ru");

        Base::$tpl->assign('aCity',array(''=>$sSelectedCity)+$aCity);
		$aCurrency=Base::$db->getAll("select * from currency where visible=1 order by num");
		Base::$tpl->assign('aCurrency',$aCurrency);

		$aData=array(
		'table'=>'rating',
		'where'=>" and section='store_customer' and num in (1,2,4)",
		//'locale_where'=>" and l.visible='1' ",
		'order'=>" order by t.num",
		);
		$aTmp=Language::GetLocalizedAll($aData);
		foreach ($aTmp as $aValue) {
			$aRating[$aValue['num']]=$aValue['content']?$aValue['content']:$aValue['name'];
		}
		Base::$tpl->assign('aRatingAssoc',$aRating);
		
		$aAdress=Db::GetAll("select * from ec_addres where id_user='".Auth::$aUser['id']."' ");
		Base::$tpl->assign('aAdress',$aAdress);

		$aData=array(
		'sHeader'=>"method=post",
		//'sTitle'=>"Customer Profile",
		'sContent'=>Base::$tpl->fetch('customer/profile.tpl'),
		'sSubmitButton'=>'Apply',
		'sSubmitAction'=>'customer_profile',
		'sError'=>$sError,
		'sWidth'=>' '
		);
		$oForm=new Form($aData);
		Base::$sText.=$oForm->getForm();

		//Base::$tpl->assign('sForm',);
		//Base::$sText.=Base::$tpl->fetch('user/outer_profile.tpl');
	}
	//-----------------------------------------------------------------------------------------------
	public function IsChangeableLogin($sLogin) {
		return preg_match("/^[a-zA-Z]{1}[0-9]*$/", $sLogin);
	}
	//-----------------------------------------------------------------------------------------------
	public function ChangeRating()
	{
		if (Base::$aRequest['num_rating']) {
			Rating::Change('store_customer',Auth::$aUser['id'],Base::$aRequest['num_rating']);
		}
	}
	//-----------------------------------------------------------------------------------------------

}
?>