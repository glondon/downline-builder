<?php
class Zend_View_Helper_Ref extends Zend_View_Helper_Abstract
{
	public function ref()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
		$refid = $auth->getIdentity()->referrer;
		} else {
		$refid = 1;
		}
		
		$users = new Model_Users();
		$result = $users->getrefUsername($refid); 
		
		return $result;
	}
}