<?php
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$acl = new Zend_Acl();
		$acl->addRole(new Zend_Acl_Role('inactive'));
		$acl->addRole(new Zend_Acl_Role('member'), 'inactive');
		$acl->addRole(new Zend_Acl_Role('upgraded'), 'member');
		$acl->addRole(new Zend_Acl_Role('admin'), 'member');
		
		$acl->add(new Zend_Acl_Resource('index'));
		$acl->add(new Zend_Acl_Resource('error'));
		$acl->add(new Zend_Acl_Resource('user'));
		$acl->add(new Zend_Acl_Resource('upgraded'));
		$acl->add(new Zend_Acl_Resource('admin'));
		
		$acl->allow(null, array('index', 'error'));
		$acl->allow('inactive', 'user', array(
			'index', 'login', 'logout', 'register', 'activate', 'resend', 'forgotpasswd', 'forgotusername', 'terms', 
			'disclaimer', 'ref', 'testajax', 'ajax'));
		$acl->allow('member', 'user', array(
			'index', 'help', 'edit', 'passwdupdate', 'preview', 'profile', 'referrals', 'upgrade', 'banners', 'custom', 'custom2', 'custom3'));
		$acl->allow('upgraded', 'user', array('bonuses'));
		$acl->allow('admin', null);
		
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$role = strtolower($identity->role);
		} else {
			$role = 'inactive';
		}
		
		$controller = $request->controller;
		$action = $request->action;
		
		if (!$acl->isAllowed($role, $controller, $action)) {
			if ($role == 'inactive') {
				$request->setControllerName('index');
				$request->setActionName('login');
			} else {
				$request->setControllerName('error');
				$request->setActionName('noauth');
			}
		}
	}
}