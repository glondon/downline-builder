<?php 

/*
* Author: Greg London
* http://greglondon.info
*/

class Model_Builder extends Zend_Db_Table_Abstract
{
	protected $_name    = 'builder';	
	protected $_primary = 'user_id';
	
	public function idInsert($id)
	{
		$row = $this->createRow();
		$row->user_id = $id;
		$row->sendearnings = '';
		$row->hits4pay = '';
		$row->inboxdollars = '';
		$row->uniquerewards = '';
		$row->clixsense = '';
		$row->surveysavvy = '';
		$row->save();
	}
	
	public function updateBuilder($sendearnings, $inboxdollars, $hits4pay, $uniquerewards, $surveysavvy, $clixsense, $id)
	{
		$where = $this->getAdapter()->quoteInto('user_id = ?', $id);
		
		$data = array(
			'sendearnings' => $sendearnings,
			'inboxdollars' => $inboxdollars,
			'hits4pay'     => $hits4pay,
			'uniquerewards'   => $uniquerewards,
			'clixsense'    => $clixsense,
			'surveysavvy'  => $surveysavvy
		);
		
		$this->update($data, $where);
	}
	
	public function getReferrer($referrer)
	{
		$select = $this->select();
		$select->where('user_id = ?', $referrer);
		$row = $this->fetchAll($select);
		return $row;
	}
	
}
