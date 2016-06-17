<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Form_Contact extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setName('contact2');
		$filter = new Zend_Filter_Alnum(array('allowwhitespace' => true));
		
		$name = $this->createElement('text', 'name');
		$name->setLabel('Name:');
		$name->setRequired(false);
		$name->addFilter(new Zend_Filter_StringTrim());
		$name->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$name->addValidator(new Zend_Validate_Alpha($filter));
		$this->addElement($name);
		
		$subject = $this->createElement('text', 'subject');
		$subject->setLabel('Subject:');
		$subject->setRequired(false);
		$subject->addFilter(new Zend_Filter_StripTags());
		$subject->addValidator(new Zend_Validate_StringLength(1, 128));
		$subject->setAttrib('size', 40);
		$this->addElement($subject);
		
		$email = $this->createElement('text', 'email');
		$email->setLabel('Email:');
		$email->setRequired(true);
		$email->addFilter(new Zend_Filter_StripTags());
		$email->addFilters(array('StringTrim', 'StringToLower'));
		$email->addValidators(array(
			array('StringLength', true, array(3, 100),
			//array('EmailAddress'),
		)));
		$email->addValidator(new Zend_Validate_EmailAddress());
		$this->addElement($email);
		
		$text = $this->createElement('textarea', 'text');
		$text->setLabel('Questions:');
		$text->setRequired(true);
		$text->addFilter(new Zend_Filter_StripTags());
		$text->addValidator(new Zend_Validate_StringLength(1, 250));
		$text->setAttrib('cols', 50);
		$text->setAttrib('rows', 10);
		$this->addElement($text);
		
		$captcha = new Zend_Form_Element_Captcha('contact',
			array('captcha' => array(
				'captcha' => 'Dumb',
				'wordLen' => 4,
				'timeout' => 600))
			);
		$captcha->setLabel('Type in the words below:');
		$this->addElement($captcha);
		
		$this->addElement('submit', 'submit', array('label' => 'Send'));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/contact');
	}
}
?>

