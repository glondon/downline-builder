<?php
class Zend_View_Helper_RefIds extends Zend_View_Helper_Abstract
{
	public function refIds()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
		$referrer = $auth->getIdentity()->referrer;
		} else if (Zend_Controller_Front::getInstance()->getRequest()->getActionName() == 'ref') {
			$request = Zend_Controller_Front::getInstance();
			if ($request->getRequest()->getParam('username') != '') {
				$user = $request->getRequest()->getParam('username');
			} else {
				$user = 'admin';
			}
			$search = new Model_Users();
    		$referrer = $search->setReferrer($user);
		} else {
		$referrer = 1;
		}
		
		$builder = new Model_Builder();
		
		$result = $builder->getReferrer($referrer); 
		
		return $result;
	}
}