<?php

/**
 * @author    "Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>"
 * @created   Feb 12, 2014 - 1:33:18 PM
 * @encoding  UTF-8
 */
namespace BIR\Component\LiveCalendar\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Base {
	/**
	 *
	 * @var \Symfony\Component\HttpFoundation\Request
	 */
	protected $request;
	
	/**
	 *
	 * @var string
	 *
	 *
	 */
	protected $database;
	
	/**
	 *
	 * @var string
	 */
	protected $content;
	
	/**
	 *
	 * @var int
	 */
	protected $status = 200;
	
	/**
	 *
	 * @var array
	 */
	protected $headers = array ();
	
	/**
	 *
	 * @param Application $app
	 *        	@codeCoverageIgnore
	 */
	public function __construct(Application $app) {
		$this->request = $app ['request'];
		$this->database = $app ['db'];
	}
	
	/**
	 *
	 * @param string $content
	 *        	@codeCoverageIgnore
	 */
	public function setContent($content) {
		$this->content = $content;
	}
	
	/**
	 *
	 * @param array $headers
	 *        	@codeCoverageIgnore
	 */
	public function setHeaders($headers) {
		$this->headers = $headers;
	}
	
	/**
	 *
	 * @param int $status
	 *        	@codeCoverageIgnore
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 *
	 * @return Response
	 */
	public function sendResponse() {
		// Dealing with JSON response only.
		$this->setContent ( json_encode ( $this->content ) );
		
		$this->setHeaders ( array (
				'Content-Type' => 'application/json; charset: utf-8;' 
		) );
		return new Response ( $this->content, $this->status, $this->headers );
	}
}