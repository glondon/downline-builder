<?php
class Form_Custom3 extends Zend_Form
{
	public function init()
	{
		$this->setName('custom3');
		$this->setMethod('post');
		$this->addElementPrefixPath('Validate', APPLICATION_PATH . '/plugins/validate/', 'validate');
		
		$title3 = $this->createElement('text', 'title3');
		$title3->setLabel('Title:');
		$title3->setRequired(true);
		$title3->addFilter(new Zend_Filter_StringTrim());
		$title3->addFilter(new Zend_Filter_StripTags());
		$title3->addFilter(new Zend_Filter_StringToLower());
		$title3->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$this->addElement($title3);
		
		$url3 = $this->createElement('text', 'url3');
		$url3->setLabel('Url:');
		$url3->setRequired(true);
		$url3->addFilter(new Zend_Filter_StringTrim());
		$url3->addFilter(new Zend_Filter_StripTags());
		$url3->addFilter(new Zend_Filter_StringToLower());
		$url3->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$url3->addValidators(array('Uri'));
		$this->addElement($url3);
		
		$description3 = $this->createElement('textarea', 'description3');
		$description3->setDescription('Description should be 100 Characters or less.');
		$description3->setLabel('Description:');
		$description3->setRequired(true);
		$description3->addFilter(new Zend_Filter_StringTrim());
		$description3->addFilter(new Zend_Filter_StripTags());
		$description3->addFilter(new Zend_Filter_StringToLower());
		$description3->addValidator(new Zend_Validate_StringLength(array('max' => 100)))->addErrorMessage('Description should be 100 characters or less.');
		$description3->setAttrib('cols', 80);
		$description3->setAttrib('rows', 5);
		$this->addElement($description3);
		
		$this->addElement('submit', 'submit3', array(
			'label' => 'Update'
		));
		
		$this->addElement('hidden', 'user_id', array(
			'filters' => array('StringTrim')
		));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/custom3/');
		
		}
}
