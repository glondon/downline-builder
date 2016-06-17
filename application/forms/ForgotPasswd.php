<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Form_ForgotPasswd extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setName('passwdupdate');
		
		$username = $this->createElement('text', 'username');
		$username->setLabel('Your Username:');
		$username->setRequired(true);
		$username->addFilters(array('StringTrim', 'StringToLower'));
		$username->addValidator(new Zend_Validate_StringLength(array('max' => 25)));
		$username->addValidator(new Zend_Validate_Db_RecordExists(array(
			'table' => 'users',
			'field' => 'username')));
		$this->addElement($username);
		
		$email = $this->createElement('text', 'email');
		$email->setLabel('Your Email:');
		$email->setRequired(true);
		$email->addFilters(array('StringTrim', 'StringToLower'));
		$email->addValidators(array(
			array('StringLength', true, array(3, 128),
			//array('EmailAddress'),
		)));
		$email->addValidator(new Zend_Validate_EmailAddress());
		//$email->addValidator(new Zend_Validate_Db_NoRecordExists(array(
		//	'table' => 'users',
		//	'field' => 'email')));
		$this->addElement($email);
		
		$captcha = new Zend_Form_Element_Captcha('signup',
			array('captcha' => array(
				'captcha' => 'Dumb',
				'wordLen' => 6,
				'timeout' => 600))
			);
		$captcha->setLabel('Captcha:');
		$this->addElement($captcha);
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Reset Password'
		));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/forgotpasswd');
	}
}