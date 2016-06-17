<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Form_PasswdUpdate extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->addElementPrefixPath('Validate', APPLICATION_PATH . '/plugins/validate/', 'validate');
		$this->setName('passwdupdate');
		
		$this->addElement('password', 'passwd', array(
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('StringLength', true, array(6, 128))
				),
				'required' => true,
				'label'    => 'Update Password:'
			));
		
		$this->addElement('password', 'passwdVerify', array(
			'filters' => array('StringTrim'),
			'validators' => array('PasswdVerify',
		),
		'required' => true,
		'label' => 'Confirm Password:',
		));
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Change Password'
		));
		
		$this->addElement('hidden', 'user_id', array(
			'filters' => array('StringTrim')
		));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/passwdupdate');
	}
}