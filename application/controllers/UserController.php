<?php

class UserController extends Zend_Controller_Action
{
	protected $_user;
	protected $_builder;
	protected $_profile;
	protected $_custom;
	
	public function init()
	{
		$auth = Zend_Auth::getInstance();
			if ($auth->hasIdentity()) {
				$this->view->identity = $auth->getIdentity();
		}
		
		$this->_user    = new Model_Users();
		$this->_builder = new Model_Builder();
		$this->_profile = new Model_Profile();
		$this->_custom  = new Model_Custom();
		
		$response = $this->getResponse();
        $response->insert('sidebar', $this->view->render('sidebar.phtml'));
		$response->insert('hbanner', $this->view->render('hbanner.phtml'));
		$response->insert('banner2', $this->view->render('banner2.phtml'));
		$response->insert('lbanner', $this->view->render('lbanner.phtml'));
		$response->insert('social', $this->view->render('social.phtml'));

		
		$this->_url = Zend_Registry::get('config')->url;
		
		$ajax = $this->_helper->getHelper('AjaxContext');
		$ajax->addActionContext('validateform', 'json')
									->initContext();
		
	}
	
	public function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->identity = $auth->getIdentity();
		}
	}
	
	public function validateformAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
		
		 $request = $this->getRequest()->getPost();
		 $message = $request['message'];
		 echo $message;

        //$contact = new Form_Contact();
        //$contact->isValid($this->_getAllParams());
        //$json = $contact->getMessages();
		
		//$passwdUpdate = new Form_PasswdUpdate();
		//$passwdUpdate->isValid($this->_getAllParams());
		//$json2 = $passwdUpdate->getMessages();
		
        //header('Content-type: application/json');
		//$this->response->setHeader('Content-type', 'application/json');
		//echo Zend_Json::encode($json);
		//if ($this->getRequest()->isXmlHttpRequest()) {
		//$jsonn = $this->_helper->json($json1);
        //echo $jsonn;
		//}
		//echo Zend_Json::encode($json2);
    }
	
	public function indexAction()
	{
		$this->view->url = $this->_url;
	}
	
	public function profileAction()
	{
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		$id = $auth->getIdentity()->user_id; 
		$info = $this->_user->find($id)->current();
		
		$dateJoined = $info->ts_created;
		$zdate = new Zend_Date();
		$zdate->set($dateJoined, 'dd-MM-YYYY');
		$this->view->datejoined = substr($zdate, 0,12);
		
		$passwdUpdate = new Form_PasswdUpdate();
		$passwdUpdate->getElement('user_id')->setValue($id);
		
		$form = new Form_Profile();
		
		if ($this->_profile->find($id)->current()) {
			$profile = $this->_profile->find($id)->current();
			$user = $profile->user_id;
			
			$form->getElement('address')->setValue($profile->address);
			$form->getElement('city')->setValue($profile->city);
			$form->getElement('state')->setValue($profile->state);
			$form->getElement('zip')->setValue($profile->zip);
			$form->getElement('country')->setValue($profile->country);
			$form->getElement('phone')->setValue($profile->phone);
			$form->getElement('dob')->setValue($profile->dob);
			
			if ($this->_profile->checkReminders($user) == true) {
				$form->getElement('reminders')->setChecked(false);
				} else {
					$form->getElement('reminders')->setValue($profile->reminders);
				}
			$form->getElement('blog')->setValue($profile->blog);		
			$form->getElement('facebook')->setValue($profile->facebook);
			$form->getElement('twitter')->setValue($profile->twitter);
			}
		
		
		$form->getElement('user_id')->setValue($info->user_id);
		
		if ($request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
			
				$user_id = $form->getValue('user_id');
				$address = $form->getValue('address');
				$city = $form->getValue('city');	
				$state = $form->getValue('state');
				$country = $form->getValue('country');
				$zip = $form->getValue('zip');
				$phone = $form->getValue('phone');
				$dob = $form->getValue('dob');
				$reminders = $form->getValue('reminders');
				$blog = $form->getValue('blog');
				$facebook = $form->getValue('facebook');
				$twitter = $form->getValue('twitter');
				
				$array = array($user_id, $address, $city, $state, $country, $zip, $phone,
							  $dob, $reminders, $blog, $facebook, $twitter);
				
				$this->_profile->updateProfile($array);
				$action = 'profileSubmitted';
				$this->view->profileSubmitted = $action;	
			}
		}
		$this->view->first_name = $info->first_name;
		$this->view->last_name = $info->last_name;
		$this->view->username = $info->username;
		$this->view->email = $info->email;
		$this->view->form = $form;
		$this->view->passwdUpdate = $passwdUpdate;
	}
	
	public function passwdupdateAction()
	{
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		$id = $auth->getIdentity()->user_id;
		$info = $this->_user->find($id)->current();
		
		$form = new Form_Profile();
		if ($this->_profile->find($id)->current()) {
			$profile = $this->_profile->find($id)->current();
			$user = $profile->user_id;
		
			$form->getElement('address')->setValue($profile->address);
			$form->getElement('city')->setValue($profile->city);
			$form->getElement('state')->setValue($profile->state);
			$form->getElement('zip')->setValue($profile->zip);
			$form->getElement('country')->setValue($profile->country);
			$form->getElement('phone')->setValue($profile->phone);
			$form->getElement('dob')->setValue($profile->dob);
			if ($this->_profile->checkReminders($user) == true) {
				$form->getElement('reminders')->setChecked(false);
				} else {
					$form->getElement('reminders')->setValue($profile->reminders);
				}
			$form->getElement('blog')->setValue($profile->blog);
			$form->getElement('facebook')->setValue($profile->facebook);
			$form->getElement('twitter')->setValue($profile->twitter);
			}
			
		$form->getElement('user_id')->setValue($id);
		
		$passwdUpdate = new Form_PasswdUpdate();
		$passwdUpdate->getElement('user_id')->setValue($id);
		
		if ($request->isPost()) {
			if ($passwdUpdate->isValid($this->_request->getPost())) {
				$passwd = $passwdUpdate->getValue('passwd');
				$user_id = $passwdUpdate->getValue('user_id');
				
				$this->_user->passwordUpdate($passwd, $user_id);
				$action = 'passwordSubmitted';
				$this->view->passwordSubmitted = $action;
			}
		}
		$this->view->passwdUpdate = $passwdUpdate;
		$this->view->first_name = $info->first_name;
		$this->view->last_name = $info->last_name;
		$this->view->username = $info->username;
		$this->view->email = $info->email;
		$this->view->form = $form;
	}
	
	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect('/');
	}
	
	public function helpAction()
	{
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		$id = $auth->getIdentity()->user_id;
		$info = $this->_user->find($id)->current();
		$form = new Form_Help();
		$this->view->form = $form;
		$form->getElement('user_id')->setValue($info->user_id);
		if ($this->getRequest()->isPost()
                && $this->view->form->isValid($this->_getAllParams())) {
		
				$subject = $form->getValue('subject');
				$text    = $form->getValue('text');
				$id      = $form->getValue('user_id');
				
				$this->_user->getContact($subject, $text, $id);
				$action = 'submitted';
				$this->view->submitted = $action;
		} 
		$canonical = $this->_url . '/user/help';
		
		$this->view->canonical = $canonical;
	}
	
	public function previewAction()
	{
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest(); 
		
		$id = $auth->getIdentity()->user_id; 
		$info = $this->_user->find($id)->current();
		$builder = $this->_builder->find($id)->current();
		
		// for custom form stuff
		$custom = new Form_Custom();
		$custom->getElement('user_id')->setValue($info->user_id);
		
		$custom2 = new Form_Custom2();
		$custom2->getElement('user_id')->setValue($info->user_id);
		
		$custom3 = new Form_Custom3();
		$custom3->getElement('user_id')->setValue($info->user_id);
		
		if ($this->_custom->find($id)->current()) {
			$cform = $this->_custom->find($id)->current();
			$custom->getElement('title')->setValue($cform->title);
			$custom->getElement('url')->setValue($cform->url);
			$custom->getElement('description')->setValue($cform->description);
			
			$custom2->getElement('title2')->setValue($cform->title2);
			$custom2->getElement('url2')->setValue($cform->url2);
			$custom2->getElement('description2')->setValue($cform->description2);
			
			$custom3->getElement('title3')->setValue($cform->title3);
			$custom3->getElement('url3')->setValue($cform->url3);
			$custom3->getElement('description3')->setValue($cform->description3);
		}
		
		$form = new Form_Builder();
		$form->getElement('user_id')->setValue($info->user_id);
		$form->getElement('sendearnings')->setValue($builder->sendearnings);
		$form->getElement('inboxdollars')->setValue($builder->inboxdollars);
		$form->getElement('hits4pay')->setValue($builder->hits4pay);
		$form->getElement('uniquerewards')->setValue($builder->uniquerewards);
		$form->getElement('clixsense')->setValue($builder->clixsense);
		$form->getElement('surveysavvy')->setValue($builder->surveysavvy);
		if ($request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
				
				$sendearnings = $form->getValue('sendearnings');	
				$inboxdollars = $form->getValue('inboxdollars');
				$hits4pay     = $form->getValue('hits4pay');
				$uniquerewards   = $form->getValue('uniquerewards');
				$clixsense   = $form->getValue('clixsense');
				$surveysavvy   = $form->getValue('surveysavvy');
				$id           = $form->getValue('user_id');
								
				$this->_builder->updateBuilder($sendearnings, $inboxdollars, $hits4pay, $uniquerewards, $clixsense, $surveysavvy, $id);
				$action = 'submitted';
				$this->view->submitted = $action;
			} 
		}

		$this->view->form = $form;
		$this->view->custom = $custom;
		$this->view->custom2 = $custom2;
		$this->view->custom3 = $custom3;
	}
	
	public function referralsAction()
	{
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		
		$id = $auth->getIdentity()->user_id; 
		$info = $this->_user->find($id)->current();
		$builder = $this->_builder->find($id)->current();
		
		$refuser = $info->user_id;
		$this->view->referrals = $this->_user->getReferrals($refuser);
	}
	
	public function upgradeAction()
	{
	
	}
	
	public function bannersAction()
	{
	
	}
	
	public function bonusesAction()
	{
	
	}
	
	public function customAction()
	{
		// all members get at least one link.
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		$id = $auth->getIdentity()->user_id;
		$info = $this->_user->find($id)->current();
		$builder = $this->_builder->find($id)->current();
		
		// for builder form stuff
		$form = new Form_Builder();
		$form->getElement('user_id')->setValue($info->user_id);
		$form->getElement('sendearnings')->setValue($builder->sendearnings);
		$form->getElement('inboxdollars')->setValue($builder->inboxdollars);
		$form->getElement('hits4pay')->setValue($builder->hits4pay);
		$form->getElement('uniquerewards')->setValue($builder->uniquerewards);
		$form->getElement('clixsense')->setValue($builder->clixsense);
		$form->getElement('surveysavvy')->setValue($builder->surveysavvy);
		
		$custom = new Form_Custom();
		$custom->getElement('user_id')->setValue($info->user_id);
		
		$custom2 = new Form_Custom2();
		$custom2->getElement('user_id')->setValue($info->user_id);
		
		$custom3 = new Form_Custom3();
		$custom3->getElement('user_id')->setValue($info->user_id);
		
		if ($this->_custom->find($id)->current()) {
			$cform = $this->_custom->find($id)->current();
			$custom->getElement('title')->setValue($cform->title);
			$custom->getElement('url')->setValue($cform->url);
			$custom->getElement('description')->setValue($cform->description);
			
			$custom2->getElement('title2')->setValue($cform->title2);
			$custom2->getElement('url2')->setValue($cform->url2);
			$custom2->getElement('description2')->setValue($cform->description2);
			
			$custom3->getElement('title3')->setValue($cform->title3);
			$custom3->getElement('url3')->setValue($cform->url3);
			$custom3->getElement('description3')->setValue($cform->description3);
		}
		
		if ($request->isPost() && $custom->isValid($request->getPost())) {
	
				$id           = $custom->getValue('user_id');
				$title        = $custom->getValue('title');	
				$url          = $custom->getValue('url');
				$description  = $custom->getValue('description');
				
				$data = array($id, $title, $url, $description);		
					
				$this->_custom->updateCustom($data);
				$action = 'custom';
				$this->view->customSubmit = $action;
				
			} else {
				$id           = $custom->getValue('user_id');
				$title        = $custom->getValue('title');	
				$url          = $custom->getValue('url');
				$description  = $custom->getValue('description');
				
				$action = 'error';
				$this->view->customError = $action;
			}
		
		$this->view->custom = $custom;
		$this->view->custom2 = $custom2;
		$this->view->custom3 = $custom3;
		$this->view->form = $form;
		
	}
	
	public function custom2Action()
	{
		//only for upgraded members
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		$id = $auth->getIdentity()->user_id;
		$info = $this->_user->find($id)->current();
		$builder = $this->_builder->find($id)->current();
		
		// for builder form stuff
		$form = new Form_Builder();
		$form->getElement('user_id')->setValue($info->user_id);
		$form->getElement('sendearnings')->setValue($builder->sendearnings);
		$form->getElement('inboxdollars')->setValue($builder->inboxdollars);
		$form->getElement('hits4pay')->setValue($builder->hits4pay);
		$form->getElement('uniquerewards')->setValue($builder->uniquerewards);
		$form->getElement('clixsense')->setValue($builder->clixsense);
		$form->getElement('surveysavvy')->setValue($builder->surveysavvy);
		
		$custom = new Form_Custom();
		$custom->getElement('user_id')->setValue($info->user_id);
		
		$custom2 = new Form_Custom2();
		$custom2->getElement('user_id')->setValue($info->user_id);
		
		$custom3 = new Form_Custom3();
		$custom3->getElement('user_id')->setValue($info->user_id);
		
		if ($this->_custom->find($id)->current()) {
			$cform = $this->_custom->find($id)->current();
			$custom->getElement('title')->setValue($cform->title);
			$custom->getElement('url')->setValue($cform->url);
			$custom->getElement('description')->setValue($cform->description);
			
			$custom2->getElement('title2')->setValue($cform->title2);
			$custom2->getElement('url2')->setValue($cform->url2);
			$custom2->getElement('description2')->setValue($cform->description2);
			
			$custom3->getElement('title3')->setValue($cform->title3);
			$custom3->getElement('url3')->setValue($cform->url3);
			$custom3->getElement('description3')->setValue($cform->description3);
		}
		
		if ($request->isPost() && $custom2->isValid($request->getPost())) {
			
				$id           = $custom2->getValue('user_id');
				$title2       = $custom2->getValue('title2');	
				$url2         = $custom2->getValue('url2');
				$description2 = $custom2->getValue('description2');
				
				$data = array($id, $title2, $url2, $description2);
				
				$this->_custom->updateCustom2($data);
				$action = 'custom';
				$this->view->customSubmit = $action;
			
			} else {
				$id           = $custom2->getValue('user_id');
				$title2       = $custom2->getValue('title2');	
				$url2         = $custom2->getValue('url2');
				$description2 = $custom2->getValue('description2');
				
				$action = 'error';
				$this->view->customError2 = $action;
			} 
		
		$this->view->custom = $custom;
		$this->view->custom2 = $custom2;
		$this->view->custom3 = $custom3;
		$this->view->form = $form;
		
	}
	
	public function custom3Action()
	{
	
		// only for upgraded members
		$auth = Zend_Auth::getInstance();
		$request = $this->getRequest();
		$id = $auth->getIdentity()->user_id;
		$info = $this->_user->find($id)->current();
		$builder = $this->_builder->find($id)->current();
		
		// for builder form stuff
		$form = new Form_Builder();
		$form->getElement('user_id')->setValue($info->user_id);
		$form->getElement('sendearnings')->setValue($builder->sendearnings);
		$form->getElement('inboxdollars')->setValue($builder->inboxdollars);
		$form->getElement('hits4pay')->setValue($builder->hits4pay);
		$form->getElement('uniquerewards')->setValue($builder->uniquerewards);
		$form->getElement('clixsense')->setValue($builder->clixsense);
		$form->getElement('surveysavvy')->setValue($builder->surveysavvy);
		
		$custom = new Form_Custom();
		$custom->getElement('user_id')->setValue($info->user_id);
		
		$custom2 = new Form_Custom2();
		$custom2->getElement('user_id')->setValue($info->user_id);
		
		$custom3 = new Form_Custom3();
		$custom3->getElement('user_id')->setValue($info->user_id);
		
		if ($this->_custom->find($id)->current()) {
			$cform = $this->_custom->find($id)->current();
			$custom->getElement('title')->setValue($cform->title);
			$custom->getElement('url')->setValue($cform->url);
			$custom->getElement('description')->setValue($cform->description);
			
			$custom2->getElement('title2')->setValue($cform->title2);
			$custom2->getElement('url2')->setValue($cform->url2);
			$custom2->getElement('description2')->setValue($cform->description2);
			
			$custom3->getElement('title3')->setValue($cform->title3);
			$custom3->getElement('url3')->setValue($cform->url3);
			$custom3->getElement('description3')->setValue($cform->description3);
		}
		
		 if ($request->isPost() && $custom3->isValid($request->getPost())) {
			
				$id           = $custom3->getValue('user_id');
				$title3       = $custom3->getValue('title3');
				$url3         = $custom3->getValue('url3');	
				$description3 = $custom3->getValue('description3');
				
				$data = array($id, $title3, $url3, $description3);
				
				$this->_custom->updateCustom3($data);
				$action = 'custom';
				$this->view->customSubmit = $action;
				
			} else {
				
				$id           = $custom3->getValue('user_id');
				$title3       = $custom3->getValue('title3');
				$url3         = $custom3->getValue('url3');	
				$description3 = $custom3->getValue('description3');
				
				$action = 'error';
				$this->view->customError3 = $action;
			}
		
		$this->view->custom = $custom;
		$this->view->custom2 = $custom2;
		$this->view->custom3 = $custom3;
		$this->view->form = $form;
		
	}
}