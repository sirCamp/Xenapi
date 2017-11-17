<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Connection\XenConnection as XenConnection;


class XenElement
{

	private $xenconnection;


	function __construct($xenconnection)
	{
		$this->xenconnection = $xenconnection;
	}

	/**
	 * Gets the value of xenconnection.
	 *
	 * @return mixed
	 */
	public function getXenconnection()
	{
		return $this->xenconnection;
	}

	/**
	 * Sets the value of xenconnection.
	 *
	 * @param mixed $xenconnection the xenconnection
	 *
	 * @return self
	 */
	private function _setXenconnection($xenconnection)
	{
		$this->xenconnection = $xenconnection;

		return $this;
	}
}

?>