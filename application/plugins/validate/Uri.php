<?php
class Validate_Uri extends Zend_Validate_Abstract
{
    const MSG_URI = 'msgUri';

    protected $_messageTemplates = array(
        self::MSG_URI => "Invalid URL",
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        //Validate the URI
        $valid = Zend_Uri::check($value);
        
        //Return validation result TRUE|FALSE   
        if ($valid)  {
            return true;
        } else {
            $this->_error(self::MSG_URI);
            return false;
        
        }

    }
}