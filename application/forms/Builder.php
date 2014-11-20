<?php
class Form_Builder extends Zend_Form
{
	public function init()
	{
		$refId = new Zend_View_Helper_RefIds();
		
		$this->setName('builder');
		
		foreach ($refId->refIds() as $ref) {
		 
		$sendearnings = $this->createElement('text', 'sendearnings');
		$sendearnings->setDecorators(array('ViewHelper', 
			array('Description', array('escape' => false)),
			array('Label', array('escape' => false))));	
		
		$sendearnings->setLabel('<b>SendEarnings:</b> Ex: "<b>ref271274</b>"');
		
		if ($ref->sendearnings != '') {
		
		$sendearnings->setDescription('<a class="tooltip" href="http://www.sendearnings.com/?r=' . $ref->sendearnings  . '" title="This is why you need to join Sendearnings a hole!" target="_blank"><img src="http://www.sendearnings.com/graphics/creative/banners/468x60/468x60_2.jpg" /></a>');
		} else {
		$sendearnings->setDescription('<a class="tooltip" href="http://www.sendearnings.com/?r=ref271274" title="This is why you need to join Sendearnings a hole!" target="_blank"><img src="http://www.sendearnings.com/graphics/creative/banners/468x60/468x60_2.jpg" /></a>');
		}
		$sendearnings->setRequired(false);
		$sendearnings->addFilter(new Zend_Filter_StringTrim());
		$sendearnings->addFilter(new Zend_Filter_Alnum());
		$sendearnings->addFilter(new Zend_Filter_StripTags());
		$sendearnings->addFilter(new Zend_Filter_StringToLower());
		$sendearnings->addValidator(new Zend_Validate_StringLength(array('max' => 12)));
		$this->addElement($sendearnings);
		
		$inboxdollars = $this->createElement('text', 'inboxdollars');
		$inboxdollars->setDecorators(array('ViewHelper', 
			array('Description', array('escape' => false)),
			array('Label', array('escape' => false))));
		$inboxdollars->setLabel('<b>InboxDollars:</b> Ex: "<b>ref948156</b>"');
		if ($ref->inboxdollars != '') {
		$inboxdollars->setDescription('<a class="tooltip" href="http://www.inboxdollars.com/?r=' . $ref->inboxdollars  . '" title="This is why you need to join Inboxdollars!" target="_blank"><img src="http://www.inboxdollars.com/graphics/creative/banners/468x60/468x60_1.gif" /></a>');
		} else {
		$inboxdollars->setDescription('<a class="tooltip" href="http://www.inboxdollars.com/?r=ref12218393" title="This is why you need to join Inboxdollars!" target="_blank"><img src="http://www.inboxdollars.com/graphics/creative/banners/468x60/468x60_1.gif" /></a>');
		}
		$inboxdollars->setRequired(false);
		$inboxdollars->addFilter(new Zend_Filter_StringTrim());
		$inboxdollars->addFilter(new Zend_Filter_Alnum());
		$inboxdollars->addFilter(new Zend_Filter_StripTags());
		$inboxdollars->addFilter(new Zend_Filter_StringToLower());
		$inboxdollars->addValidator(new Zend_Validate_StringLength(array('max' => 12)));
		$this->addElement($inboxdollars);
		
		$hits4pay = $this->createElement('text', 'hits4pay');
		$hits4pay->setDecorators(array('ViewHelper', 
			array('Description', array('escape' => false)),
			array('Label', array('escape' => false))));
		$hits4pay->setLabel('<b>Hits4Pay:</b> Ex: "<b>USERNAME</b>"');
		if ($ref->hits4pay != '') {
		$hits4pay->setDescription('<a class="tooltip" href="http://hits4pay.com/members/index.cgi?' . $ref->hits4pay . '" title="Join Hits4pay today!" target="_blank"><img src="http://hits4pay.com/imgn/banners/468x60.png" /></a>');
		} else {
		$hits4pay->setDescription('<a class="tooltip" href="http://hits4pay.com/members/index.cgi?gdc25" title="Join Hits4pay today!" target="_blank"><img src="http://hits4pay.com/imgn/banners/468x60.png" /></a>');
		}
		$hits4pay->setRequired(false);
		$hits4pay->addFilter(new Zend_Filter_StringTrim());
		$hits4pay->addFilter(new Zend_Filter_Alnum());
		$hits4pay->addFilter(new Zend_Filter_StripTags());
		$hits4pay->addFilter(new Zend_Filter_StringToLower());
		$hits4pay->addValidator(new Zend_Validate_StringLength(array('max' => 12)));
		$this->addElement($hits4pay);
		
		$uniquerewards = $this->createElement('text', 'uniquerewards');
		$uniquerewards->setDecorators(array('ViewHelper', 
			array('Description', array('escape' => false)),
			array('Label', array('escape' => false))));
		$uniquerewards->setLabel('<b>UniqueRewards:</b> Ex: "<b>111000</b>"');
		if ($ref->uniquerewards != '') {
		$uniquerewards->setDescription('<a class="tooltip" href="http://www.uniquerewards.com/cgi-bin/main.cgi?cmd=newref&refid=' . $ref->uniquerewards . '" title="Join Unique Rewards today!" target="_blank"><img src="http://www.uniquerewards.com/banners/banner1.gif" /></a>');
		} else {
		$uniquerewards->setDescription('<a class="tooltip" href="http://www.uniquerewards.com/cgi-bin/main.cgi?cmd=newref&refid=9440" title="Join Unique Rewards today!" target="_blank"><img src="http://www.uniquerewards.com/banners/banner1.gif" /></a>');
		}
		$uniquerewards->setRequired(false);
		$uniquerewards->addFilter(new Zend_Filter_StringTrim());
		$uniquerewards->addFilter(new Zend_Filter_Alnum());
		$uniquerewards->addFilter(new Zend_Filter_StripTags());
		$uniquerewards->addFilter(new Zend_Filter_StringToLower());
		$uniquerewards->addValidator(new Zend_Validate_StringLength(array('max' => 12)));
		$this->addElement($uniquerewards);
		
		$clixsense = $this->createElement('text', 'clixsense');
		$clixsense->setDecorators(array('ViewHelper', 
			array('Description', array('escape' => false)),
			array('Label', array('escape' => false))));
		$clixsense->setLabel('<b>Clixsense:</b> Ex: "<b>111000</b>"');
		if ($ref->clixsense != '') {
		$clixsense->setDescription('<a class="tooltip" href="http://www.clixsense.com/?' . $ref->clixsense . '" title="Join Clixsense today!" target="_blank"><img src="http://csstatic.com/banners/clixsense_gpt468x60a.png" /></a>');
		} else {
		$clixsense->setDescription('<a class="tooltip" href="http://www.clixsense.com/?2251204" title="Join Clixsense today!" target="_blank"><img src="http://csstatic.com/banners/clixsense_gpt468x60a.png" /></a>');
		}
		$clixsense->setRequired(false);
		$clixsense->addFilter(new Zend_Filter_StringTrim());
		$clixsense->addFilter(new Zend_Filter_Alnum());
		$clixsense->addFilter(new Zend_Filter_StripTags());
		$clixsense->addFilter(new Zend_Filter_StringToLower());
		$clixsense->addValidator(new Zend_Validate_StringLength(array('max' => 12)));
		$this->addElement($clixsense);
		
		$surveysavvy = $this->createElement('text', 'surveysavvy');
		$surveysavvy->setDecorators(array('ViewHelper', 
			array('Description', array('escape' => false)),
			array('Label', array('escape' => false))));
		$surveysavvy->setLabel('<b>Surveysavvy:</b> Ex: "<b>111000</b>"');
		if ($ref->surveysavvy != '') {
		$surveysavvy->setDescription('<a class="tooltip" href="https://www.surveysavvy.com/?m=' . $ref->surveysavvy . '" title="Join Survey Savvy today!" target="_blank"><img src="http://www.signupandmakemoney.com/Assets/affiliate/surveysavvy-banner468.jpg" /></a>');
		} else {
		$surveysavvy->setDescription('<a class="tooltip" href="https://www.surveysavvy.com/?m=2450703" title="Join Survey Savvy today!" target="_blank"><img src="http://www.signupandmakemoney.com/Assets/affiliate/surveysavvy-banner468.jpg" /></a>');
		}
		$surveysavvy->setRequired(false);
		$surveysavvy->addFilter(new Zend_Filter_StringTrim());
		$surveysavvy->addFilter(new Zend_Filter_Alnum());
		$surveysavvy->addFilter(new Zend_Filter_StripTags());
		$surveysavvy->addFilter(new Zend_Filter_StringToLower());
		$surveysavvy->addValidator(new Zend_Validate_StringLength(array('max' => 12)));
		$this->addElement($surveysavvy);
		
		}
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Update'
		));
		
		$this->addElement('hidden', 'user_id', array(
			'filters' => array('StringTrim')
		));
		
		$this->setMethod('post');
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/preview/');
	}
}
