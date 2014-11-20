<?php
class Form_Help extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setName('help');
		
		$subject = $this->createElement('text', 'subject');
		$subject->setLabel('Subject:');
		$subject->setRequired(true);
		$subject->addFilter(new Zend_Filter_StripTags());
		$subject->addValidator(new Zend_Validate_StringLength(1, 128));
		$subject->setAttrib('size', 40);
		$this->addElement($subject);
		
		$text = $this->createElement('textarea', 'text');
		$text->setLabel('Text:');
		$text->setRequired(true);
		$text->addFilter(new Zend_Filter_StripTags());
		$text->addValidator(new Zend_Validate_StringLength(1, 250));
		$text->setAttrib('cols', 50);
		$text->setAttrib('rows', 10);
		$this->addElement($text);
		
		$id = $this->createElement('hidden', 'user_id');
		$id->addValidator(new Zend_Validate_Alnum());
		$id->addFilter(new Zend_Filter_StripTags());
		$this->addElement($id);
		
		$this->addElement('submit', 'submit', array('label' => 'Send'));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/help');
		//$this->setAction('/user/validateform');
	}
}
?>
