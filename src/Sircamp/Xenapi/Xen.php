<?php namespace Sircamp\Xenapi;

use Respect\Validation\Validator as Validator;
use Sircamp\Xenapi\Connection\XenConnection as XenConnection;
use Sircamp\Xenapi\Connection\XenResponse as XenResponse;
use Sircamp\Xenapi\Element\XenHost as XenHost;
use Sircamp\Xenapi\Element\XenVirtualMachine as XenVirtualMachine;

class Xen
{

	private $xenconnection = null;

	public function __construct($url, $user, $password)
	{


		if (!Validator::ip()->validate($url))
		{

			throw new \InvalidArgumentException("'url' value mast be an ipv4 address", 1);

		}
		if (!Validator::stringType()->validate($user))
		{
			throw new \InvalidArgumentException("'user' value mast be an non empty string", 1);
		}

		if (!Validator::stringType()->validate($password))
		{
			throw new \InvalidArgumentException("'password' value mast be an non empty string", 1);
		}

		$this->xenconnection = new XenConnection();
		try
		{
			$this->xenconnection->_setServer($url, $user, $password);
		}
		catch (\Exception $e)
		{
			die($e->getMessage());
		}
	}

	/**
	 * Get VM inside Hypervisor from name.
	 *
	 * @param mixed $name the name of VM
	 *
	 * @return mixed
	 */
	public function getVMByNameLabel($name): XenVirtualMachine
	{
		$response = new XenResponse($this->xenconnection->VM__get_by_name_label($name));

		return new XenVirtualMachine($this->xenconnection, $name, $response->getValue()[0]);
	}

	/**
	 * Get HOST from name.
	 *
	 * @param mixed $name the name of HOST
	 *
	 * @return mixed
	 */
	public function getHOSTByNameLabel($name)
	{
		$response = new XenResponse($this->xenconnection->host__get_by_name_label($name));

		return new XenHost($this->xenconnection, $name, $response->getValue()[0]);
	}


}

?>