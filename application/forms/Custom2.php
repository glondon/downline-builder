<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Form_Custom2 extends Zend_Form
{
	public function init()
	{
		$this->setName('custom2');
		$this->setMethod('post');
		$this->addElementPrefixPath('Validate', APPLICATION_PATH . '/plugins/validate/', 'validate');
		
		$title2 = $this->createElement('text', 'title2');
		$title2->setLabel('Title:');
		$title2->setRequired(true);
		$title2->addFilter(new Zend_Filter_StringTrim());
		$title2->addFilter(new Zend_Filter_StripTags());
		$title2->addFilter(new Zend_Filter_StringToLower());
		$title2->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$this->addElement($title2);
		
		$url2 = $this->createElement('text', 'url2');
		$url2->setLabel('Url:');
		$url2->setRequired(true);
		$url2->addFilter(new Zend_Filter_StringTrim());
		$url2->addFilter(new Zend_Filter_StripTags());
		$url2->addFilter(new Zend_Filter_StringToLower());
		$url2->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$url2->addValidators(array('Uri'));
		$this->addElement($url2);
		
		$description2 = $this->createElement('textarea', 'description2');
		$description2->setDescription('Description should be 100 Characters or less.');
		$description2->setLabel('Description:');
		$description2->setRequired(true);
		$description2->addFilter(new Zend_Filter_StringTrim());
		$description2->addFilter(new Zend_Filter_StripTags());
		$description2->addFilter(new Zend_Filter_StringToLower());
		$description2->addValidator(new Zend_Validate_StringLength(array('max' => 100)))->addErrorMessage('Description should be 100 characters or less.');
		$description2->setAttrib('cols', 80);
		$description2->setAttrib('rows', 5);
		$this->addElement($description2);
		
		$this->addElement('submit', 'submit2', array(
			'label' => 'Update'
		));
		
		$this->addElement('hidden', 'user_id', array(
			'filters' => array('StringTrim')
		));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/custom2/');
		
		}
}
