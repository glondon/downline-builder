<?php

class IndexController extends Zend_Controller_Action
{
	protected $user;
	protected $_builder;
	protected $_profile;
	protected $_custom;

    public function init()
    {
    	$auth = Zend_Auth::getInstance();
			if ($auth->hasIdentity()) {
			$this->view->identity = $auth->getIdentity();
		} 
		
        $this->_user = new Model_Users();
		$this->_builder = new Model_Builder();
		$this->_profile = new Model_Profile();
		$this->_custom = new Model_Custom();
        
        $response = $this->getResponse();
        $response->insert('sidebar', $this->view->render('sidebar.phtml'));
		$response->insert('hbanner', $this->view->render('hbanner.phtml'));
		$response->insert('banner2', $this->view->render('banner2.phtml'));
		$response->insert('lbanner', $this->view->render('lbanner.phtml'));
		$response->insert('social', $this->view->render('social.phtml'));
		
		$this->_url = Zend_Registry::get('config')->url;
		
		$totalUsers = $this->_user->countUsers();
		$this->view->totalUsers = $totalUsers;
    }
    
	public function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->identity = $auth->getIdentity();
		} 
	}
	
	public function ajaxAction()
    {
		$request = $this->getRequest()->getPost();
		$message = $request['message'];
		 
        $this->_helper->viewRenderer->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		 
		 echo $message;	 
	}

    public function indexAction()
    {
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			
			$this->view->alreadylogged = 'You have successfully logged in!';
		}
    	$canonical = $this->_url . '/';
		$this->view->canonical = $canonical;
		
		
    }
	
	public function testajaxAction()
	{
	
	}
	
	public function termsAction()
	{
		$canonical = $this->_url . '/terms';
		$this->view->canonical = $canonical;
		$this->_helper->layout()->disableLayout();
		
		/* $response = $this->getResponse();
        $response->extract('sidebar', $this->view->render('sidebar.phtml'));
		$response->extract('hbanner', $this->view->render('hbanner.phtml'));
		$response->extract('banner2', $this->view->render('banner2.phtml'));
		$response->extract('lbanner', $this->view->render('lbanner.phtml'));
		$response->extract('social', $this->view->render('social.phtml')); */
	}
	
	public function disclaimerAction()
	{
		$canonical = $this->_url . '/disclaimer';
		$this->view->canonical = $canonical;
	}
	
	public function forgotpasswdAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity())
			$this->_redirect('/');
		
		$request = $this->getRequest();
		$form = new Form_ForgotPasswd();
		
		if ($request->isPost() && $form->isValid($_POST)) {
			$username = $form->getValue('username');
			$email = $form->getValue('email');
			
			$db = Zend_Db_Table::getDefaultAdapter();
			$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'email');
			$authAdapter->setIdentity($username);
			$authAdapter->setCredential($email); 
			$result = $authAdapter->authenticate();
			
			if (!$result->isValid()) {
				$this->view->matchEmail = 'Username does not match email record.';
			} else {
			
				$this->_user->newPassword($username);
				$action = 'submitted';
				$this->view->submitted = $action;
			}
		}
		$this->view->form = $form;
	}
	
	public function forgotusernameAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity())
			$this->_redirect('/');
		
		$request = $this->getRequest();
		$form = new Form_ForgotUsername();
		
		if ($request->isPost() && $form->isValid($_POST)) {
			$email = $form->getValue('email');
			$passwd = $form->getValue('passwd');
			
			$db = Zend_Db_Table::getDefaultAdapter();
			$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'email', 'passwd', 'md5(?)');
			$authAdapter->setIdentity($email);
			$authAdapter->setCredential($passwd); // should make md5() on password
			$result = $authAdapter->authenticate();
			
			if (!$result->isValid()) {
				$this->view->matchPass = 'Password did not match email record.';
			} else {
			
			$this->_user->sendUsername($email);
			$action = 'submitted';
			$this->view->submitted = $action;
			}
		}
		$this->view->form = $form;
	}
	
	public function registerAction()
	{		
		
		$sess = new Zend_Session_Namespace('ref');
		$refid = $sess->id;
		$referrer = $refid;
		
		if ($refid == '') {
			$refid = 1;
			$referrer = 1;
		} 
		
		$refusername = $this->_user->getrefUsername($refid);
		
		
		if ($this->_user->checkUsername($refusername) == 0) {
			$refusername = 'admin';
			$referrer = 1;
		}
    	
    	$request = $this->getRequest();
    	$form = new Form_Register();
    	$form->getElement('referrer')->setValue($referrer);
    	if ($request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
					
				$firstname = $form->getValue('first_name');
				$lastname = $form->getValue('last_name');
				$username = $form->getValue('username');
				$email = $form->getValue('email');
				$passwd = $form->getValue('passwd');
				$ref = $form->getValue('referrer');	
				
				$ip = $request->getServer('REMOTE_ADDR');
								
				$this->_user->registerUser($firstname, $lastname, $username, $email, $passwd, $ref, $ip);
				$action = 'submitted';
				$this->view->submitted = $action;
			}
		}
			
		$canonical = $this->_url . '/register';
		$this->view->form = $form;
		$this->view->canonical = $canonical;
		$this->view->refusername = $refusername;
	}
	
	public function loginAction()
	{	
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			
			$this->view->alreadylogged = 'You are already logged in!';
		}
		
		$form = new Form_Login();
		if ($this->_request->isPost() && $form->isValid($_POST)) {
			$data = $form->getValues();
			
			$db = Zend_Db_Table::getDefaultAdapter();
			$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'passwd', 'md5(?)');
			$authAdapter->setIdentity($data['username']);
			$authAdapter->setCredential($data['passwd']); 
			$username = $data['username'];
			$result = $authAdapter->authenticate();
			
			if ($this->_user->checkActive($username) == false) {
				
					$this->view->loginMessage = 'Sorry, you still need to confirm your email address. <a href="/user/resend?user=' . $username . '">Send it again!</a>';
					$this->_user->loginFailure($username, $result->getCode());
					
			} elseif ($result->isValid()) {
				$auth = Zend_Auth::getInstance();
				$storage = $auth->getStorage();
				$storage->write($authAdapter->getResultRowObject(array(
				'user_id', 'username', 'email', 'first_name', 'last_name', 'role', 'referrer')));
				
				$remember = $data['remember'];
				
				if ($data['remember'] == 0) {
							// do not remember the session
                            Zend_Session::forgetMe();
                        } else {
                            // remember the session for 604800s = 7 days
                            Zend_Session::rememberMe(604800);
                        }
			
				
				$this->_user->loginSuccess($username, $remember);
				
				return $this->_redirect('/');
				
			} else {
				$this->view->loginMessage = 'Sorry, your username or password was incorrect.';
				$this->_user->loginFailure($username, $result->getCode());
				
			}
		} 
		
		$canonical = $this->_url . '/login';
		$this->view->form = $form;
		$this->view->canonical = $canonical;
		
	}
	
	public function resendAction()
	{
		$userToActivate = $this->_request->getQuery('user');
		if ($this->_user->activateUser($userToActivate) == false) {
			$this->view->false = 'false';
		} elseif ($this->_user->activateUser($userToActivate) == true) {
			$this->view->true = 'true';
		} else {
		$activate = $this->_user->activateUser($userToActivate);
		}
	}
	
	public function activateAction()
	{
		$emailToActivate = $this->_request->getQuery('email');
		if ($this->_user->activateEmail($emailToActivate) == true) {
			$this->view->true = 'true';
		} elseif ($this->_user->activateEmail($emailToActivate) == false) {
			$this->view->false = 'false';
		} else {
			$activate = $this->_user->activateEmail($emailToActivate);
		}
	}
	
	public function refAction()
	{	
		if ($this->getRequest()->getParam('username')) {
			$user = $this->getRequest()->getParam('username');
    		$referrer = $this->_user->setReferrer($user);
			
    	} else {
		
			$referrer = 1;
			
		}
		
		$refid = $referrer;
		$theUsername = $this->_user->getrefUsername($refid);
		$custom = $this->_custom->getCustom($refid);
		
		$request = $this->getRequest();
    	$form = new Form_Register();
    	$form->getElement('referrer')->setValue($referrer);
    	if ($request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
					
				$firstname = $form->getValue('first_name');
				$lastname = $form->getValue('last_name');
				$username = $form->getValue('username');
				$email = $form->getValue('email');
				$passwd = $form->getValue('passwd');
				$ref = $form->getValue('referrer');	
				
				$ip = $request->getServer('REMOTE_ADDR');
								
				$this->_user->registerUser($firstname, $lastname, $username, $email, $passwd, $ref, $ip);
				$action = 'submitted';
				$this->view->submitted = $action;
			}
		}
		// still need to store this in a session somehow
		$sess = new Zend_Session_Namespace('ref');
		$referrer = $sess->id;
		
		$this->view->form = $form;
    	$this->view->refid = $theUsername;
		//$this->view->custom = $custom;
		
		$canonical = $this->_url . '/ref/' . $theUsername;
		$this->view->canonical = $canonical;
		
	}

}

