<?

class Favourites extends Base
{

	//-----------------------------------------------------------------------------------------------
	public function __construct()
	{
		Repository::InitDatabase('favourites', false);
	}
	//-----------------------------------------------------------------------------------------------
	public function Index()
	{
		Base::$oContent->AddCrumb(Language::GetMessage('favourites'),'');
		
		$oTable=new Table();
		$oTable->iRowPerPage=20;
		$oTable->iStartStep=1;
		if (Auth::$aUser['id'])
		{
		    $sSql ="select f.*,p.*,b.*,pr.* , p.name, b.name as brand, p.id as code from favourites as f 
		        left join ec_products as p on f.id_product=p.id
		        inner join ec_price as pr on pr.id_product=p.id
			    left join ec_brand as b on b.id=p.id_brand
		        where f.id_user='".Auth::$aUser['id']."' group by f.id";
		    $oTable->sSql=$sSql;
		}
		else
		{
		    $oTable->sSql="select f.*,p.*,b.*,pr.*, p.name, b.name as brand, p.id as code from favourites as f 
		        left join ec_products as p on f.id_product=p.id
		        inner join ec_price as pr on pr.id_product=p.id
			    left join ec_brand as b on b.id=p.id_brand
		        where f.id_session='".session_id()."' group by f.id";
		}
		$oTable->aOrdered="order by p.id desc";
		/*$oTable->aColumn=array(
	    'code'=>array('sTitle'=>'Code'),
		'name'=>array('sTitle'=>'name'),
		'brand'=>array('sTitle'=>'brand'),
		'post_date'=>array('sTitle'=>'Date'),
		'action'=>array('sTitle'=>''),
		);*/
		$oTable->sTemplateName = 'index_include/favourites_table.tpl';
		$oTable->sDataTemplate='favourites/row_favourites.tpl';

		Base::$sText.=$oTable->getTable("Favourites");
	}
	//-----------------------------------------------------------------------------------------------
	public function AddFavourites()
	{
		$aLog=array(
		'id_user'=>Auth::$aUser['id']
		,'id_product'=>Base::$aRequest['id']
		);
		if (!Auth::$aUser['id'])
		{
			$aLog['id_session']=session_id();
		}
		Db::AutoExecute('favourites', $aLog, 'INSERT');
		//Base::Redirect('/?action=catalog_product&product='.Base::$aRequest['id']);

	}
	//-----------------------------------------------------------------------------------------------
    public function DelFavourites()
	{
		if (Auth::$aUser['id']){
		    Db::Execute("delete from favourites where id_product='".Base::$aRequest['id']."' ".Auth::$sWhere);
		}
		else {
		    Db::Execute("delete from favourites where id_product='".Base::$aRequest['id']."' and id_session='".session_id()."'");
		}
		
		//Base::Redirect('/?action=catalog_product&product='.Base::$aRequest['id']);

	}
	//-----------------------------------------------------------------------------------------------
	public function UpdateFavourites()
	{
	    if (Auth::$aUser['id']){
		    $iNumber=Db::GetOne("select count(*) from favourites where id_user=".Auth::$aUser['id']);
		}
		else {
		    $iNumber=Db::GetOne("select count(*) from favourites where id_session='".session_id()."'");
		}
		if (Base::$aRequest['xajax_request']) {
		    Base::$oResponse->AddAssign('ifav_id','innerHTML',$iNumber);
		}else{
		    return $iNumber;
		}
		    
	    //Base::Redirect('/?action=catalog_product&product='.Base::$aRequest['id']);
	
	}
	//-----------------------------------------------------------------------------------------------

}
?>