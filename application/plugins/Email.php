<?php
class Plugin_Email 
{
	const FROM_NAME  = 'Make Money Site';
	const FROM_EMAIL = 'i@y.com';
	
	public function setup()
	{
		$config = array('ssl'      => 'tls',
			            'port'     =>  587, 
                        'auth'     => 'login',
                        'username' => 'y@g.com',
                        'password' => 'NotAvailable'
		);
	
		// 465 could also work for port
		
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        
        return $transport;
	}
}