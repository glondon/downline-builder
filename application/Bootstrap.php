<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$modelLoader = new Zend_Application_Module_Autoloader(array(
					'namespace' => '',
					'basePath'  => APPLICATION_PATH));
										
		return $modelLoader;
	}
	
	public function _initView()
	{
		$view = new Zend_View();
		$view->doctype('XHTML1_TRANSITIONAL');
		$view->headTitle('Downline Builder')->setSeparator(' - ');
		$view->headMeta();
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		
		return $view;
	}
	
	protected function _initLog()
	{
		$logger = new Zend_Log(new Zend_Log_Writer_Stream('../data/logs/debug.log'));
		Zend_Registry::set('logger', $logger);
	}
	
	protected function _initConfig()
	{
		$config = new Zend_Config($this->getOptions());
    	Zend_Registry::set('config', $config);
	}
	
	protected function _initSession()
	{
		Zend_Session::start();
	}
	
	protected function _initRouter()
	{
		$fc = Zend_Controller_Front::getInstance();
		$router = $fc->getRouter();
		$router->addRoute(
			'username',
			new Zend_Controller_Router_Route('/ref/:username', array('controller' => 'index',
																'action' => 'ref'))
		);
		$router->addRoute(
			'ref',
			new Zend_Controller_Router_Route('/ref/', array('controller' => 'index',
																'action' => 'ref'))
		);
		
		$router->addRoute(
			'home',
			new Zend_Controller_Router_Route('/', array('controller' => 'index',
																'action' => 'index'))
		);
		$router->addRoute(
			'terms',
			new Zend_Controller_Router_Route('/terms/', array('controller' => 'index',
																'action' => 'terms'))
		);
		$router->addRoute(
			'disclaimer',
			new Zend_Controller_Router_Route('/disclaimer/', array('controller' => 'index',
																'action' => 'disclaimer'))
		);
		$router->addRoute(
			'register',
			new Zend_Controller_Router_Route('/register/', array('controller' => 'index',
																'action' => 'register'))
		);
		$router->addRoute(
			'login',
			new Zend_Controller_Router_Route('/login/', array('controller' => 'index',
																'action' => 'login'))
		);
		$router->addRoute(
			'resend',
			new Zend_Controller_Router_Route('/resend/', array('controller' => 'index',
																'action' => 'resend'))
		);
		$router->addRoute(
			'activate',
			new Zend_Controller_Router_Route('/activate/', array('controller' => 'index',
																'action' => 'activate'))
		);
		$router->addRoute(
			'forgotpasswd',
			new Zend_Controller_Router_Route('/forgotpasswd/', array('controller' => 'index',
																'action' => 'forgotpasswd'))
		);
		$router->addRoute(
			'forgotusername',
			new Zend_Controller_Router_Route('/forgotusername/', array('controller' => 'index',
																'action' => 'forgotusername'))
		);
	}
}

