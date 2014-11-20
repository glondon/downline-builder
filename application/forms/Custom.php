<?php
class Form_Custom extends Zend_Form
{
	public function init()
	{
		$this->setName('custom');
		$this->setMethod('post');
		$this->addElementPrefixPath('Validate', APPLICATION_PATH . '/plugins/validate/', 'validate');
		
		$title = $this->createElement('text', 'title');
		$title->setLabel('Title:');
		$title->setRequired(true);
		$title->addFilter(new Zend_Filter_StringTrim());
		$title->addFilter(new Zend_Filter_StripTags());
		$title->addFilter(new Zend_Filter_StringToLower());
		$title->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$this->addElement($title);
	
		$url = $this->createElement('text', 'url');
		$url->setLabel('Url:');
		$url->setRequired(true);
		$url->addFilter(new Zend_Filter_StringTrim());
		$url->addFilter(new Zend_Filter_StripTags());
		$url->addFilter(new Zend_Filter_StringToLower());
		$url->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$url->addValidators(array('Uri'));
		$this->addElement($url);
		
		$description = $this->createElement('textarea', 'description');
		$description->setDescription('Description should be 100 Characters or less.');
		$description->setLabel('Description:');
		$description->setRequired(true);
		$description->addFilter(new Zend_Filter_StringTrim());
		$description->addFilter(new Zend_Filter_StripTags());
		$description->addFilter(new Zend_Filter_StringToLower());
		$description->addValidator(new Zend_Validate_StringLength(array('max' => 100)))->addErrorMessage('Description should be 100 characters or less.');
		$description->setAttrib('cols', 80);
		$description->setAttrib('rows', 5);
		$this->addElement($description);
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Update'
		));
		
		$this->addElement('hidden', 'user_id', array(
			'filters' => array('StringTrim')
		));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/custom/');
	}
}