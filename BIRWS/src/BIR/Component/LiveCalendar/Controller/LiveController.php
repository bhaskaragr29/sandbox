<?php

/**
 * @author    "Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>"
 * @created   Feb 12, 2014 - 1:33:18 PM
 * @encoding  UTF-8
 */
namespace BIR\Component\LiveCalendar\Controller;

use BIR\Component\LiveCalendar\Controller\Base;
use BIR\Component\LiveCalendar\Repositry\LiveCalendarRepositry;

class LiveController extends Base {
	/**
	 *
	 * @param array $ids        	
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getLivecalendarByIds(array $ids) {
		$live_data = new LiveCalendarRepositry ( $this->database );
		$type = $this->request->query->get ( 'type' );
		$conditions = array ();
		if (! empty ( $type ))
			$conditions ['type'] = $type;
		$this->setContent ( array (
				'live_calendar' => $live_data->findByIds ( ($ids [0] != 0) ? $ids : array (), $conditions ) 
		) );
		return $this->sendResponse ();
	}
	
	/**
	 *
	 * @param integer $id        	
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function createUpdateLiveCalendar($id) {
		$live_data = new LiveCalendarRepositry ( $this->database );
		$data = $this->request->request->all ();
		$result = $live_data->save ( $data );
		$is_valid = $this->validate ( $data );
		if ($result && $is_valid) {
			$this->setContent ( array (
					'live_calendar' => $live_data->find ( array (
							$result 
					) ) 
			) );
		} else {
			$this->setContent ( array (
					'error' => 'Failed to update or insert item: ' . $data ['id'] 
			) );
			$this->setStatus ( 500 );
		}
		return $this->sendResponse ();
	}
	public function validate($data) {
		if (empty ( $data ['data'] )) {
			return FALSE;
		}
		if (empty ( $data ['type'] )) {
			return FALSE;
		}
		return TRUE;
	}
}