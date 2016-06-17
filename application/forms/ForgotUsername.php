<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Form_ForgotUsername extends Zend_Form
{
	public function init()
	{
		$this->setName('forgotusername');
		
		$email = $this->createElement('text', 'email');
		$email->setLabel('Your email:');
		$email->setRequired(true);
		$email->addFilters(array('StringTrim', 'StringToLower'));
		$email->addValidators(array(
			array('StringLength', true, array(3, 128),
			//array('EmailAddress'),
		)));
		$email->addValidator(new Zend_Validate_EmailAddress());
		$email->addValidator(new Zend_Validate_Db_RecordExists(array(
			'table' => 'users',
			'field' => 'email')));
		$this->addElement($email);
		
		$passwd = new Zend_Form_Element_Password('passwd');
		$passwd->setLabel('Your password:');
		$passwd->setRequired(true);
		$passwd->addFilter(new Zend_Filter(StringTrim));
		$passwd->addValidator(new Zend_Validate_StringLength(array(6, 128)));
		$this->addElement($passwd);
		
		$captcha = new Zend_Form_Element_Captcha('signup',
			array('captcha' => array(
				'captcha' => 'Dumb',
				'wordLen' => 6,
				'timeout' => 600))
			);
		$captcha->setLabel('Captcha:');
		$this->addElement($captcha);
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Send Username'
		));
		
		$this->setMethod('post');
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/forgotusername');
	}
}