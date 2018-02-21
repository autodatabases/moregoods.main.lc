<?
require_once(SERVER_PATH.'/class/core/Admin.php');
class AAccountLog extends Admin {
	//-----------------------------------------------------------------------------------------------
	function AAccountLog() {
	}
	
	//-----------------------------------------------------------------------------------------------
	/**
	 * On search action return search result form
	 *
	 * @param String $sSearchLoginField - name of the login field in the search table
	 * @param array $aData - previously set where parameter
	 * @param boolean $bIsUserAccount - Need for get data by account log. $bIsUserAccount==true for user_account_log.
	 * @return  assign to Base::$sText search result
	 */
	protected function GetResultByFindLogin($sSearchLoginField='login', $aData= array(), $bIsUserAccount= false){
		if ($this->aSearch [$sSearchLoginField]){
			$aData['where'] = $this->sSearchSQL;

			$bIsOne = false;
			if ($bIsUserAccount){
				$aSearchResult = Base::$db->GetAll(Base::GetSql('UserAccountLog', $aData));
				$bIsOne = $aSearchResult && count($aSearchResult)>0 ? true : false;
				if ($aSearchResult) {
					$iId = $aSearchResult[0]['id_user'];
					foreach ($aSearchResult as $key => $aValue){
						if ($iId != $aValue['id_user']){
							$bIsOne = false;
							break;
						}
					}
				}
			}
			
			$aFind = array();
			if ($bIsOne){
				$aFind = Base::$db->GetRow (Base::GetSql ( 'Customer',array ('login' => $aSearchResult[0]['user'] ) ) );
			}elseif (count($aSearchResult) == 0){
				$aFind = Base::$db->GetRow (Base::GetSql ( 'Customer',array ('login' => $this->aSearch [$sSearchLoginField]) ) );
			}

			Base::$tpl->assign( 'aSearchResult', $aFind);
			Base::$sText .= Base::$tpl->fetch('mpanel/user_account_log/form_search_result.tpl');
		}
	}
}
?>