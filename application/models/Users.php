<?php
class Model_Users extends Zend_Db_Table_Abstract
{
	protected $_name    = 'users';	
	protected $_primary = 'user_id';
	
	// recently add reminders to put at how many reminders sent.
	
	public function registerUser($firstname, $lastname, $username, $email, $passwd, $ref, $ip)
	{
		$date = new Zend_Db_Expr('NOW()');
		
		$row = array(
		'first_name' => $firstname,
		'last_name' => $lastname,
		'username' => $username,
		'email' => $email,
		'passwd' => md5($passwd), 
		'role' => 'inactive', //changes to member after confirmed email
		'referrer' => $ref, 
		'ip' => $ip,
		'ts_created' => $date
		);
		$this->insert($row);
		
		$id = $this->_db->lastInsertId();
		
		$to = $row['email'];
		$name = $row['first_name'];
		$options = new Plugin_Email();
		$body = '
		<p>' . $name . ',<br><br>Thanks for taking the time to join the Sign up Bonus Downline Builder.</p>
		 <p>Please confirm your email address to become an active member of the site:</p>
		 <p><a href="http://paidtosignup/activate?email=' . $to . '">
		 http://paidtosignup/activate?email=' . $to . '</a></p>
		 <p>If you did not sign up for an account, please ignore this email.</p>';
		
		$fromEmail = Plugin_Email::FROM_EMAIL;
		$fromName = Plugin_Email::FROM_NAME;
		$subject = 'Welcome to the Downline Builder, please confirm your email address';
			
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom($fromEmail, $fromName);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->send($options->setup());
		
		$builder = new Model_Builder();
		$builder->idInsert($id);
		
		if ($ref > 1) {
			// We will add to this email in the future
			$select = $this->select();
			$select->where('user_id = ?', $ref);
			$data = $this->fetchRow($select);
			$refbody = 'Your new referral\'s username is ' . $row['username'] . '.';
			$refto = $data->email;
			$refsubject = 'Congrats ' . $data->first_name . ', you got a new referral.';
		
			$refMail = new Zend_Mail();
			$refMail->setBodyHtml($refbody);
			$refMail->setFrom($fromEmail, $fromName);
			$refMail->addTo($refto);
			$refMail->setSubject($refsubject);
			$refMail->send($options->setup());
		}
	}
	
	public function activateEmail($emailToActivate)
	{
		$select = $this->select();
		$select->where('email = ?', $emailToActivate);
			   
		$result = $this->fetchRow($select);
		
		if (isset($result->role) == 'member') {
			return true;
			
		} elseif (isset($result->email)) {
			
			$data = array('role' => 'member');
			$where = $this->getAdapter()->quoteInto('email = ?', $emailToActivate);
			$this->update($data, $where);
			
			} else {
				return false;
		}					
	}
	
	public function activateUser($userToActivate)
	{
		$select = $this->select();
		$select->where('username = ?', $userToActivate);
		$result = $this->fetchRow($select);
		
		if (isset($result->role) == 'member') {
			return true;
		
		} elseif (isset($result->username)) {
		
		$to = $result->email;
		$name = $result->first_name;
		$options = new Plugin_Email();
		$body = '
		<p>' . $name . ',<br><br>Once again, thanks for taking the time to join this awesome Money Making site. Here is a resend of the
			confirmation email that was misplaced earlier. </p>
		 <p>Please try to confirm your email address again to become an active member of the site:</p>
		 <p><a href="http://paidtosignup/activate?email=' . $to . '">
		 http://paidtosignup/activate?email=' . $to . '</a></p>
		 <p>If you did not sign up for an account, please ignore this email.</p>
		 <p>Note: If you still cannot activate your account reply to this email and we will manually take a look at your account.</p>';
		
		$fromEmail = Plugin_Email::FROM_EMAIL;
		$fromName = Plugin_Email::FROM_NAME;
		$subject = 'Resend, please try to confirm your email address again.';
			
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom($fromEmail, $fromName);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->send($options->setup());
		
		} else {
			return false;
		}
	}
	
	public function refCount($refuser)
	{
		$select = $this->select();
		$select->where('referrer = ?', $refuser);
		$rows = $this->fetchAll($select);
		$count = $rows->count();
		return $count;
	}
	
	public function countUsers()
	{
		$select = $this->select();
		$rows = $this->fetchAll($select);
		$count = $rows->count();
		return $count;
	}
	
	public function newestMembers()
	{
		$currentDate = new Zend_Db_Expr('NOW()');
		
		$select = $this->select();
		$select->from('users');
		$select->where('ts_created < ?', $currentDate)->limit(5)->order('ts_created DESC');
		$result = $this->fetchAll($select);
		return $result;
		
	}
	
	public function getReferrals($refuser)
	{
		$select = $this->select();
		$select->where('referrer = ?', $refuser);
		$rows = $this->fetchAll($select);
		return $rows;
	}
	
	public function setReferrer($user)
	{
		$select = $this->select();
		$select->where('username = ?', $user);
		$row = $this->fetchRow($select);
		if (!isset($row)) {
			$ref = 1;
			return $ref;
		} else {
			$ref = $row->user_id;
			return $ref;
		}
	}
	
	public function getrefUsername($refid)
	{
		$select = $this->select();
		$select->where('user_id = ?', $refid);
		$ref = $this->fetchAll($select);
		foreach ($ref as $it) {
			$refUser = $it->username;
	
			return $refUser;
		}
	}
	
	public function checkUsername($refusername)
	{
		// making sure username is in database
		$select = $this->select();
		$select->where('username = ?', $refusername);
		$result = $this->fetchRow($select);

		if ($result->username) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function checkActive($username)
	{
		$select = $this->select();
		$select->where('username = ?', $username);
		$result = $this->fetchRow($select);
		
		if (!isset($result->username)) {
			$username = '';
			return true;
		} elseif ($result->role == 'inactive') {
			return false;
		} else {
			return true;
		}
		
	}
	
	public function loginSuccess($username, $remember)
	{
		$date = new Zend_Db_Expr('NOW()');
		$where = $this->getAdapter()->quoteInto('username = ?', $username);
		$data = array('ts_last_login' => $date, 'reminder' => '');
		
		$this->update($data, $where);
		
		$message = sprintf('Successful login attempt from %s user %s remember %s', 
							$_SERVER['REMOTE_ADDR'],
							$username, $remember);

		$logger = Zend_Registry::get('logger');
		$logger->notice($message);
	}
	
	static public function loginFailure($username, $code = '')
	{
		switch ($code) {
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
				$reason = 'Unknown username';
				break;
			case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
				$reason = 'Multiple users found with this username';
				break;
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
				$reason = 'Invalid username or password';
				break;
			default:
				$reason = 'Not sure what happened or not confirmed';
		}
		
		$message = sprintf('Failed login attempt from %s user %s', 
							$_SERVER['REMOTE_ADDR'],
							$username);
							
		if (strlen($reason) > 0)
			$message .= sprintf(' (%s)', $reason);
			
		$logger = Zend_Registry::get('logger');
		$logger->warn($message);
	}
	
	public function newPassword($username)
	{
		$select = $this->select();
		$select->where('username = ?', $username)
			   ->limit(1);
		
		$data = $this->fetchRow($select);
		$newPasswd = uniqid();
		
		// update the user's row here
		$where = $this->getAdapter()->quoteInto('username = ?', $username);
		$update = array('passwd' => md5($newPasswd));
		$this->update($update, $where);
		
		$name = $data->first_name;
		$to = $data->email;
		$options = new Plugin_Email();
		$fromName = Plugin_Email::FROM_NAME;
		$subject = 'Your new password.';
		$body = '<p>Hello ' . $name . ',</p>
				 <p>You recently requested a new password.</p>
				 <p>Your new password is <b>' . $newPasswd . '</b>.</p>
				 <p>If you did not request a new password, 
				 	please reply to this email immediately
				 	to let us know.</p>';
		
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom($fromName);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->send($options->setup());
	}
	
	public function sendUsername($email)
	{
		$select = $this->select();
		$select->where('email = ?', $email)
			   ->limit(1);
		
		$data = $this->fetchRow($select);
		
		// send username to the member
		$name = $data->first_name;
		$to = $data->email;
		$username = $data->username;
		$options = new Plugin_Email();
		$fromName = Plugin_Email::FROM_NAME;
		$subject = 'Your Username.';
		$body = '<p>Hello ' . $name . ',</p>
				 <p>You recently requested your username.</p>
				 <p>Your username is <b>' . $username . '</b>.</p>
				 <p>If you did not request your username, 
				 	please reply to this email immediately
				 	to let us know.</p>';
		
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom($fromName);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->send($options->setup());
	}
	
	public function getContact($subject, $text, $id)
	{	
		$select = $this->select();
		$select->where('user_id = ?', $id)
			   ->limit(1);
		
		$data = $this->fetchRow($select);
		
		$options = new Plugin_Email();
		$fromName = $data->first_name; 
		$fromEmail = $data->email;
		$to = 'info@signupandmakemoney.com'; // sending to admin
		
		$mail = new Zend_Mail();
		$mail->setBodyText($text . ' ::::::Sent from userId: ' . $data->user_id);
		$mail->setFrom($fromEmail, $fromName);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->send($options->setup());
	}
	
	public function passwordUpdate($passwd, $user_id)
	{
		$protected = md5($passwd);
		$where = $this->getAdapter()->quoteInto('user_id = ?', $user_id);
		$data = array('passwd' => $protected);
		
		$this->update($data, $where);
	}
	
	public function loginMonthCheck()
	{
		$date = new Zend_Date();
		$month = $date->get(Zend_Date::MONTH); // current month
		
		if ($month == 01) {
			$twoMonths = 11;
		} elseif ($month == 02) {
			$twoMonths = 12;
		} else {
			$twoMonths = $month - 2; 
		}
		
		$select = $this->select();
		$select->from('users');
		$select->where('ts_last_login');
		$result = $this->fetchAll($select);
		
		$count = count($result);
		
		if ($count > 0) {
		$i = 0;
			foreach ($result as $row) {
				$lastLogin = $row->ts_last_login;
				$zdate = new Zend_Date($lastLogin);
				$lmonth = $zdate->get(Zend_Date::MONTH); // month last logged in
				
				if ($lmonth <= $twoMonths) {
					$i++;
					return $i + 1;
				}
			}
		} else {
			return 'No';
		}
	}
	
	public function monthReminder()
	{	
		$date = new Zend_Date();
		$month = $date->get(Zend_Date::MONTH); // current month
		
		if ($month == 01) {
			$twoMonths = 11;
		} elseif ($month == 02) {
			$twoMonths = 12;
		} else {
			$twoMonths = $month - 2; 
		}
		
		$select = $this->select();
		$select->from('users');
		$select->where('ts_last_login');
		$result = $this->fetchAll($select);
		
		$count = count($result);
		
		if ($count > 0) {
		$i = 0;
		foreach ($result as $row) {
		
		$lastLogin = $row->ts_last_login;
		$reminder = $row->reminder;
		$user = $row->user_id;
		$zdate = new Zend_Date($lastLogin);
		$lmonth = $zdate->get(Zend_Date::MONTH); // month last logged in
		
		$profile = new Model_Profile;
		if ($profile->checkReminders($user) == true) {
			$spam = false;
		} else {
			$spam = true;
		}
		
			if ($lmonth <= $twoMonths && $reminder == '' && $spam !== false) {
			
				$options = new Plugin_Email();
				$fromName = Plugin_Email::FROM_NAME; 
				$fromEmail = Plugin_Email::FROM_EMAIL;
				$to = $row->email;
				$subject = 'Reminder to log into your Make Money Website.';
				$text = '<p>Hello ' . $row->first_name . ',</p>
						<p>Thank you for joining this site, however our system shows you have not logged in recently.</p>
						<p>Please keep your account active by logging in regularly, otherwise you may miss out.</p>
						<p>To unsubscribe from reminders like this, please login and update your profile.</p>
						<p>Please DO NOT reply to this automated message. If you require assistance, please use our Support form.</p>
						<p>Regards,</p>
						<p>The Make Money Site Team.<br />
						<a href="http://paidtosignup">http://paidtosignup</a></p>';
		
				$mail = new Zend_Mail();
				$mail->setBodyHtml($text);
				$mail->setFrom($fromEmail, $fromName);
				$mail->addTo($to);
				$mail->setSubject($subject);
				$mail->send($options->setup());
			
				$info = 'oneMonth';
				$where = $this->getAdapter()->quoteInto('user_id = ?', $user);
				$data = array('reminder' => $info);
				$this->update($data, $where);
				$i++;
				return $i + 1;
				}
			}
		}  else {
			return false;
		}
	}
	
	public function getIp()
	{
		//Test if it is a shared client
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
  		$ip = $_SERVER['HTTP_CLIENT_IP'];
		//Is it a proxy address
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
  		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
  		$ip = $_SERVER['REMOTE_ADDR'];
		}
		//The value of $ip at this point would look something like: "192.0.34.166"
		$ip = ip2long($ip);
		//The $ip would now look something like: 1073732954
		
		//$sql = "INSERT INTO user(ip) VALUES('$ip')";
		//$dbQuery = mysql_query($sql,$dbLink);
		// to retrieve the ip - do the following:
		//SELECT INET_NTOA(ip) FROM 'user' WHERE 1
	}
}

