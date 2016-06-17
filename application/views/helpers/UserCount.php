<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Zend_View_Helper_UserCount extends Zend_View_Helper_Abstract
{
	public function userCount()
	{
		
		$users = new Model_Users();	
		$count = $users->countUsers();
		return $count;
	}
}
