<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Zend_View_Helper_RefCount extends Zend_View_Helper_Abstract
{

	public function refCount()
	{
		$auth = Zend_Auth::getInstance();
		$refuser = $auth->getIdentity()->user_id; 
		
		$users = new Model_Users();
		
		$count = $users->refCount($refuser);
		
		return $count;
	}
}
