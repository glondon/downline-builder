<?php

/*
* Author: Greg London
* http://greglondon.info
*/

class Model_Custom extends Zend_Db_Table_Abstract
{
	protected $_name    = 'custom';	
	protected $_primary = 'user_id';
	
	public function updateCustom($data)
	{
		$select = $this->select();
		$select->where('user_id = ?', $data[0]);
		$result = $this->fetchRow($select);
		
		if (!$result) {
			
			$row = array(
			'user_id'      => $data[0],
			'title'        => $data[1],
			'url'          => $data[2],
			'description'  => $data[3]
			);
			$this->insert($row);
			
			} else {
				$user = $result->user_id;
				
				$row = array(
				'title'        => $data[1],
				'url'          => $data[2],
				'description'  => $data[3]
			);
			$where = $this->getAdapter()->quoteInto('user_id = ?', $user);
			$this->update($row, $where);
			
			}
	}
	
	public function updateCustom2($data)
	{
		$select = $this->select();
		$select->where('user_id = ?', $data[0]);
		$result = $this->fetchRow($select);
		
		if (!$result) {
			
			$row = array(
			'user_id'      => $data[0],
			'title2'       => $data[1],
			'url2'         => $data[2], 
			'description2' => $data[3] 
			);
			$this->insert($row);
			
			} else {
				$user = $result->user_id;
				
				$row = array(
				
				'title2'       => $data[1],
				'url2'         => $data[2], 
				'description2' => $data[3] 
			);
			$where = $this->getAdapter()->quoteInto('user_id = ?', $user);
			$this->update($row, $where);
			
			}
	}
	
	public function updateCustom3($data)
	{
		$select = $this->select();
		$select->where('user_id = ?', $data[0]);
		$result = $this->fetchRow($select);
		
		if (!$result) {
			
			$row = array(
			'user_id'      => $data[0],
			'title3'       => $data[1],
			'url3'         => $data[2],
			'description3' => $data[3]
			);
			$this->insert($row);
			
			} else {
				$user = $result->user_id;
				
				$row = array(
				'title3'       => $data[1],
				'url3'         => $data[2],
				'description3' => $data[3]
			);
			$where = $this->getAdapter()->quoteInto('user_id = ?', $user);
			$this->update($row, $where);
			
			}
	}
	
	public function getCustom($refid)
	{
		$select = $this->select();
		$select->where('user_id = ?', $refid);
		$result = $this->fetchRow($select);
		
		return $result;
	}
}
