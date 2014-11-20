<?php

class AdminController extends Zend_Controller_Action
{
	public function init()
	{
		// Initialize action controller here
		$this->_user = new Model_Users();
		$this->_builder = new Model_Builder();
		$this->_profile = new Model_Profile();
		$this->_custom = new Model_Custom();
        
        $response = $this->getResponse();
        $response->insert('sidebar', $this->view->render('sidebar.phtml'));
		
		$this->_url = Zend_Registry::get('config')->url;
	}
	
	public function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->identity = $auth->getIdentity();
		}
	}
	
	public function indexAction()
	{	
		$userTBL = new Model_Users();
		$this->view->users = $userTBL->fetchAll();
	}
	
	public function cronAction()
	{
		$form = new Form_Month();
		$this->view->form = $form;
		$this->view->needIt = $this->_user->loginMonthCheck();
		if ($this->_request->isPost()) {
			if ($this->_user->monthReminder() !== false) {
			$this->view->monthReminder = 'Reminder Sent.';
			$this->view->sent = $this->_user->monthReminder();
			} else {
				$this->view->noMonth = 'No Reminder Sent.';
			}
		}
	}
}
?>