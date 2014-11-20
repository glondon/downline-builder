<?php
class Form_Month extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setName('month');
	
		$send = new Zend_Form_Element_Submit('submit');
		$send->setLabel('Send Month Reminder');
		$this->addElement($send);
	
	$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/cron');
	}
}
?>
