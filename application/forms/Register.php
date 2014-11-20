<?php 
class Form_Register extends Zend_Form
{
	public function init()
	{
		// add path to custom validators
		$this->addElementPrefixPath('Validate', APPLICATION_PATH . '/plugins/validate/', 'validate');
		
		$this->setName('register');
		
		$firstname = $this->createElement('text', 'first_name');
		$firstname->setLabel('Firstname:');
		$firstname->setRequired(true);
		$firstname->addFilter(new Zend_Filter_StringTrim());
		$firstname->addValidator(new Zend_Validate_StringLength(array('max' => 128)));
		$firstname->addValidator(new Zend_Validate_Alpha());
		$this->addElement($firstname);
		
		$lastname = $this->createElement('text', 'last_name');
		$lastname->setLabel('Lastname:');
		$lastname->setRequired(true);
		$lastname->addFilter(new Zend_Filter_StringTrim());
		$lastname->addValidator(new Zend_Validate_StringLength(array('max' => 128)));
		$lastname->addValidator(new Zend_Validate_Alpha());
		$this->addElement($lastname);
		
		$username = $this->createElement('text', 'username');
		$username->setLabel('Username:');
		$username->setRequired(true);
		$username->addFilters(array('StringTrim', 'StringToLower'));
		$username->addValidator(new Zend_Validate_StringLength(array('max' => 25)));
		$username->addValidator(new Zend_Validate_Db_NoRecordExists(array(
			'table' => 'users',
			'field' => 'username')));
		$this->addElement($username);
		
		$email = $this->createElement('text', 'email');
		$email->setLabel('Email:');
		$email->setRequired(true);
		$email->addFilters(array('StringTrim', 'StringToLower'));
		$email->addValidators(array(
			array('StringLength', true, array(3, 128),
			//array('EmailAddress'),
		)));
		$email->addValidator(new Zend_Validate_EmailAddress());
		$email->addValidator(new Zend_Validate_Db_NoRecordExists(array(
			'table' => 'users',
			'field' => 'email')));
		$this->addElement($email);
		
		$this->addElement('password', 'passwd', array(
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('StringLength', true, array(6, 128))
				),
				'required' => true,
				'label'    => 'Password:'
			));
		
		$this->addElement('password', 'passwdVerify', array(
			'filters' => array('StringTrim'),
			'validators' => array('PasswdVerify',
		),
		'required' => true,
		'label' => 'Confirm Password:',
		));
		
		$captcha = new Zend_Form_Element_Captcha('signup',
			array('captcha' => array(
				'captcha' => 'Dumb',
				'wordLen' => 4,
				'timeout' => 600))
			);
		$captcha->setLabel('');
		$this->addElement($captcha);
		
		$terms = new Zend_Form_Element_Checkbox('terms');
		$terms->setLabel('<div style="padding-top:20px;">I agree to the <a href="javascript: terms()" title="View our Terms & Conditiions">Terms & Conditions</a></div>');
		$terms->getDecorator('label')->setOption('escape', false);
		$terms->setRequired(true);
		$terms->addValidator(new Zend_Validate_InArray(array(1)), false);
		$terms->addErrorMessage('You must agree to the Terms & Conditions.');
		$this->addElement($terms);
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Register'
		));
		
		$this->addElement('hidden', 'referrer', array(
			'filters' => array('StringTrim')
		));
		
		/** still need to add ip detection
		$validator = new Zend_Validate_Ip();
		if ($validator->isValid($ip)) {
   		 // ip appears to be valid
		} else {
    	// ip is invalid; print the reasons
		} 
		$this->addElement('hidden', 'ip');
		**/
		
		$this->setMethod('post');
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/register');
	}
}
?>