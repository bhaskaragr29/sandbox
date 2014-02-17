<?php

namespace BIR\Component\LiveCalendar\Entity;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\BooleanType;

/**
 *
 * @author "Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>"
 *         @created Feb 12, 2014 - 1:33:02 PM
 *         @encoding UTF-8
 */
class LiveCalendar {
	/**
	 *
	 * @var IntegerType
	 */
	protected $id;
	
	/**
	 *
	 * @var
	 *
	 *
	 */
	protected $created_at;
	
	/**
	 *
	 * @var DateTime
	 */
	protected $updated_at;
	
	/**
	 *
	 * @var stringcreated
	 */
	protected $type;
	
	/**
	 *
	 * @var TextType
	 */
	protected $data;
	
	/**
	 *
	 * @var boolean
	 */
	protected $active;
	
	/**
	 *
	 * @return \Doctrine\DBAL\Types\IntegerType
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @param unknown $id        	
	 * @return unknown
	 */
	public function setId($id) {
		return $this->id = $id;
	}
	
	/**
	 *
	 * @return \BIR\Component\LiveCalendar\Entity\DateTime
	 */
	public function getCreatedAt() {
		return $this->created_at;
	}
	public function setCreatedAt($created_at) {
		return $this->created_at = $created_at;
	}
	
	/**
	 *
	 * @return \BIR\Component\LiveCalendar\Entity\DateTime
	 */
	public function getUpdateAt() {
		return $this->updated_at;
	}
	public function setUpdatedAt($updated_at) {
		return $this->updated_at = $updated_at;
	}
	
	/**
	 *
	 * @return \Doctrine\DBAL\Types\IntegerType
	 */
	public function getType() {
		return $this->type_id;
	}
	public function setType($type) {
		return $this->type = $type;
	}
	
	/**
	 *
	 * @return \Doctrine\DBAL\Types\TextType
	 */
	public function getData() {
		return $this->data;
	}
	public function setData($data) {
		return $this->data = $data;
	}
	
	/**
	 *
	 * @return \Doctrine\DBAL\Types\BooleanType
	 */
	public function getActive() {
		return $this->active;
	}
	public function setActive($active) {
		return $this->active = $active;
	}
	public function _toObj() {
		$properties = get_object_vars ( $this );
		$object = new \StdClass ();
		foreach ( $properties as $name => $value ) {
			$object->$name = $value;
		}
		return $object;
	}
}