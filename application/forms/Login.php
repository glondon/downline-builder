<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Form_Login extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setName('login');
		
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Username:');
		$username->setRequired(true);
		$username->addFilter(new Zend_Filter_StripTags());
		$username->addFilters(array('StringTrim', 'StringToLower'));
		$username->addValidator(new Zend_Validate_StringLength(array('max' => 25)));
				 
		$passwd = new Zend_Form_Element_Password('passwd');
		$passwd->setLabel('Password:');
		$passwd->setRequired(true);
		$passwd->addFilter(new Zend_Filter(StringTrim));
		$passwd->addValidator(new Zend_Validate_StringLength(array(6, 100)));
		
		$remember = new Zend_Form_Element_Checkbox('remember');
		$remember->setLabel('<div style="padding-top:20px;">Keep me logged in</div>');
		$remember->getDecorator('label')->setOption('escape', false);
		 
		$login = new Zend_Form_Element_Submit('submit');
		$login->setLabel('Login');
		
		$this->addElements(array($username, $passwd, $remember, $login));
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/login');
	}
}
?>
