<?
/**
 * @author Mikhail Kuleshov
 */
class PriceSearchLog extends Base
{

	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Repository::InitDatabase('price_search_log', false);
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$oContent->AddCrumb(Language::GetMessage('price_search_log'),'');
		
		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->iStartStep=1;
		if (Auth::$aUser['id'])
		{
			$oTable->sSql="select psl.*	, p.name, b.name as brand, if(p.art is null,psl.code,p.art) as code
			    from price_search_log as psl 
			    left join ec_products as p on p.art=psl.code or psl.id_product=p.id
			    left join ec_brand as b on b.id=p.id_brand
			    where psl.id_user='".Auth::$aUser['id']."'";
		}
		else
		{
			$oTable->sSql="select psl.*	, p.name, b.name as brand, if(p.art is null,psl.code,p.art) as code
			    from price_search_log as psl 
			    left join ec_products as p on p.art=psl.code or psl.id_product=p.id
			    left join ec_brand as b on b.id=p.id_brand
			    where psl.id_session='".session_id()."'";
		}
		$oTable->aOrdered="order by psl.post_date desc";
		$oTable->aColumn=array(
		'cat_name'=>array('sTitle'=>'Make'),
		'code'=>array('sTitle'=>'Code'),
		'post'=>array('sTitle'=>'Date'),
		'action'=>array('sTitle'=>''),
		);
		$oTable->sDataTemplate='price_search_log/row_price_search_log.tpl';

		Base::$sText.=$oTable->getTable("Price Search Log",'Price Search Log');
	}
	//-----------------------------------------------------------------------------------------------
	public function AddSearch()
	{
		if (!Base::GetConstant('price_search_log:is_available',1)) return;
		if (!Base::$aRequest['code'] && !Base::$aRequest['product']) return;
		$aLog=array(
		'id_user'=>Auth::$aUser['id']
		,'id_product'=>Base::$aRequest['product']
		,'code'=>Base::$aRequest['code']
		);
		if (!Auth::$aUser['id'])
		{
			$aLog['id_session']=session_id();
		}
// 		if (Base::$aRequest['product'])
// 		{
// 			$sCatName=Db::GetOne("select name from cat where pref='".Base::$aRequest['pref']."'");
// 			if ($sCatName)
// 			{
// 				$aLog['cat_name']=$sCatName;
// 			}
// 		}

		Db::AutoExecute('price_search_log', $aLog, 'INSERT');

	}
	//-----------------------------------------------------------------------------------------------

}
?>