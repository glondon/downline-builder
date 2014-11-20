<?php
class Zend_View_Helper_RefProfile extends Zend_View_Helper_Abstract
{
	public function refProfile()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
		$referrer = $auth->getIdentity()->referrer;
		} else {
		$referrer = 1;
		} 
		
		$profile = new Model_Profile();
		
		$result = $profile->getProfile($referrer); 
		
		return $result;
	}
}
