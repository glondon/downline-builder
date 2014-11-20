<?php
class Model_Profile extends Zend_Db_Table_Abstract
{
	protected $_name    = 'profile';	
	protected $_primary = 'user_id';
	
	public function updateProfile($array)
	{
		$select = $this->select();
		$select->where('user_id = ?', $array[0]);
		$result = $this->fetchRow($select);
		
		if (!$result) {
			
			$row = array(
			'user_id'   => $array[0],
			'address'   => $array[1],
			'city'      => $array[2],
			'state'     => $array[3],
			'country'   => $array[4],
			'zip'       => $array[5], 
			'phone'     => $array[6], 
			'dob'       => date($array[7]),
			'reminders' => $array[8],
			'blog'      => $array[9],
			'facebook'  => $array[10],
			'twitter'   => $array[11]
			);
			$this->insert($row);
		
			} else {
			
			$user = $result->user_id;
			
			$data = array(
			'address'   => $array[1],
			'city'      => $array[2],
			'state'     => $array[3],
			'country'   => $array[4],
			'zip'       => $array[5], 
			'phone'     => $array[6], 
			'dob'       => date($array[7]),
			'reminders' => $array[8],
			'blog'      => $array[9],
			'facebook'  => $array[10],
			'twitter'   => $array[11]
			);
			$where = $this->getAdapter()->quoteInto('user_id = ?', $user);
			$this->update($data, $where);
			
			} 
		
	}	
	
	public function checkReminders($user)
	{
		$select = $this->select();
		$select->from('profile');
		$select->where('user_id = ?', $user);
		$result = $this->fetchAll($select);
		
		$count = count($result);
		
		if ($count > 0) {
			foreach ($result as $row) {
				$reminders = $row->reminders;
				if ($reminders == 'no') {
					return true;
				} else {
					return false;
				}
			}
		} else {
		
				if (isset($result->reminders) == 'no') {
					return true;
				} else {
					return false;
			}
		}
	}
	
	public function getFacebook($refid)
	{
		$select = $this->select();
		$select->where('user_id = ?', $refid);
		$result = $this->fetchRow($select);
		
		return $result->facebook;
	}
	
	public function getTwitter($refid)
	{
		$select = $this->select();
		$select->where('user_id = ?', $refid);
		$result = $this->fetchRow($select);
		
		return $result->twitter;
	}
	
	public function getProfile($referrer)
	{
		$select = $this->select();
		$select->where('user_id = ?', $referrer);
		$row = $this->fetchAll($select);
		return $row;
	}
	
}
