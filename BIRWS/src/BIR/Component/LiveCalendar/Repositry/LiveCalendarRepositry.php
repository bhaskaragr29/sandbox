<?php

/**
 * @author    "Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>"
 * @created   Feb 13, 2014 - 3:10:28 PM
 * @encoding  UTF-8
 */
namespace BIR\Component\LiveCalendar\Repositry;

use Doctrine\DBAL\Connection;
use BIR\Component\LiveCalendar\Entity\LiveCalendar;

/**
 * Live Calendar Repositry
 */
class LiveCalendarRepositry {
	
	/**
	 *
	 * @var \Doctrine\DBAL\Connection
	 */
	protected $db;
	
	/**
	 *
	 * @var string
	 */
	protected $table = 'live_calendar';
	public function __construct(Connection $db) {
		$this->db = $db;
	}
	
	/**
	 * Return Total No of rows
	 *
	 * @return integer
	 */
	public function getCount() {
		return $this->db->fetchColumn ( "SELECT COUNT(id) FROM " . $this->table );
	}
	
	/**
	 *
	 * @param array $ids        	
	 * @param array $conditions        	
	 * @return Ambigous <\multitype:\BIR\Component\LiveCalendar\Entity\LiveCalendar, multitype:NULL >
	 */
	public function findByIds($ids, $conditions = array(), $limit = 100, $offset = 0, $orderBy = array()) {
		$ids = (is_array ( $ids )) ? $ids : array (
				$ids 
		);
		$queryBuilder = $this->db->createQueryBuilder ();
		
		$queryBuilder->select ( 'live.*' )->from ( $this->table, 'live' );
		if (! empty ( $ids ))
			$queryBuilder->where ( $queryBuilder->expr ()->in ( 'live.id', $ids ) );
			
			// @TODO:only for type:: condition later can be changed
		if (! empty ( $conditions ['type'] )) {
			$type_clause = array ();
			foreach ( $conditions ['type'] as $key => $val ) {
				if (is_string ( $val )) {
					$type_clause [$key] = '"' . $val . '"';
				}
			}
			$queryBuilder->andWhere ( 'live.type IN (' . implode ( ",", $type_clause ) . ')' );
		}
		
		if (! $orderBy) {
			$orderBy = array (
					'created_at' => 'DESC' 
			);
		}
		$queryBuilder->setMaxResults ( $limit )->setFirstResult ( $offset )->orderBy ( 'live.' . key ( $orderBy ), current ( $orderBy ) );
		$statement = $queryBuilder->execute ();
		$liveData = $statement->fetchAll ();
		return $this->wrapLiveCalendar ( $liveData );
	}
	
	/**
	 *
	 * @param array $live_calendars        	
	 * @return multitype:\BIR\Component\LiveCalendar\Entity\LiveCalendar
	 */
	public function wrapLiveCalendar(array $live_calendars) {
		$wrapped = array ();
		foreach ( $live_calendars as $item ) {
			$wrapped [] = $this->buildLiveCalendar ( $item );
		}
		return $wrapped;
	}
	
	/**
	 *
	 * @param array $liveCalendar
	 *        	The array of db data.
	 *        	
	 * @return \BIR\Component\LiveCalendar\Entity\LiveCalendar
	 * @todo : Also add uri to each off the objec that that is getting returned
	 */
	protected function buildLiveCalendar($liveCalendarData) {
		$live_calendar = new LiveCalendar ();
		$live_calendar->setId ( $liveCalendarData ['id'] );
		$live_calendar->setData ( $liveCalendarData ['data'] );
		$active = ( bool ) ($liveCalendarData ['active']);
		$live_calendar->setActive ( $active );
		$live_calendar->setCreatedAt ( $liveCalendarData ['created_at'] );
		if (isset ( $liveCalendarData ['updated_at'] )) {
			$live_calendar->setUpdatedAt ( $liveCalendarData ['updated_at'] );
		} else {
			$live_calendar->setUpdatedAt ( $liveCalendarData ['created_at'] );
		}
		$live_calendar->setType ( $liveCalendarData ['type'] );
		return $live_calendar->_toObj ();
	}
	
	/**
	 *
	 * @param Array $liveCalendarData        	
	 * @return string boolean
	 */
	public function save($liveCalendarData) {
		if (is_object ( $liveCalendarData )) {
			$liveCalendarData = json_decode ( $liveCalendarData, true );
		}
		$updateCriteria = array ();
		// @TODO::Need to validate the upcoming data
		$updateCriteria = $liveCalendarData ['id'] !== null ? array (
				'id' => $liveCalendarData ['id'] 
		) : $updateCriteria;
		unset ( $liveCalendarData ['id'] );
		if (! empty ( $updateCriteria )) {
			$result = $this->db->update ( $this->table, $liveCalendarData, $updateCriteria );
			$id = $updateCriteria ['id'];
		} else {
			$liveCalendarData ['created_at'] = time ();
			$result = $this->db->insert ( $this->table, $liveCalendarData );
			$id = $this->db->lastInsertId ();
		}
		if ($result == 1) {
			return $id;
		} else {
			return FALSE;
		}
	}
	
	/**
	 *
	 * @return
	 *
	 *
	 */
	public function deleteLast24Hours() {
		$sql = 'DELETE FROM ' . $this->table . ' WHERE updated_at < :time';
		// Delete those whose update date is 24 hours old
		$stmt = $this->db->executeQuery ( $sql, array (
				'time' => strtotime ( "-1 day" ) 
		) );
		return $stmt->execute ();
	}
}