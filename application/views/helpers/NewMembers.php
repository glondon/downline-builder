<?php
class Zend_View_Helper_NewMembers extends Zend_View_Helper_Abstract
{
	public function newMembers()
	{
		
		$users = new Model_Users();
		$result = $users->newestMembers(); 
		
		return $result;
	}
}
