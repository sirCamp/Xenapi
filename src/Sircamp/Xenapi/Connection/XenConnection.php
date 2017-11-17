<?php namespace Sircamp\Xenapi\Connection;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Exception\XenConnectionException as XenConnectionException;

class XenConnection
{


	private $url;
	private $session_id;
	private $user;
	private $password;

	function __construct()
	{

		$this->session_id = null;
		$this->url        = null;
		$this->user       = null;
		$this->password   = null;

	}

	/**
	 * Gets the value of url.
	 *
	 * @return mixed
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Sets the value of url.
	 *
	 * @param mixed $url the url
	 *
	 * @return self
	 */
	private function _setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Gets the value of session_id.
	 *
	 * @return mixed
	 */
	public function getSessionId()
	{
		return $this->session_id;
	}

	/**
	 * Sets the value of session_id.
	 *
	 * @param mixed $session_id the session id
	 *
	 * @return self
	 */
	private function _setSessionId($session_id)
	{
		$this->session_id = $session_id;

		return $this;
	}

	/**
	 * Gets the value of user.
	 *
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Sets the value of user.
	 *
	 * @param mixed $user the user
	 *
	 * @return self
	 */
	private function _setUser($user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Gets the value of password.
	 *
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Sets the value of password.
	 *
	 * @param mixed $password the password
	 *
	 * @return self
	 */
	private function _setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Sets all values of object.
	 *
	 * @param mixed $password the password, mixed $url the url,
	 *                        mixed $session_id the session_id and mixed 4user the user
	 *
	 * @return self
	 */

	function _setAll($url, $session_id, $user, $password)
	{

		$this->_setPassword($password);
		$this->_setSessionId($session_id);
		$this->_setUrl($url);
		$this->_setUser($user);

		return $this;
	}

	/**
	 * Sets and initialize xen server connection
	 *
	 * @param mixed $url the ip, mixed $user the user and mixed $password the password,
	 *
	 *
	 * @return XenResponse
	 */

	function _setServer($url, $user, $password)
	{

		$response = $this->xenrpc_request($url, $this->xenrpc_method('session.login_with_password', array($user, $password, '1.3.1')));

		if (Validator::arrayType()->validate($response) && Validator::key('Status', Validator::equals('Success'))->validate($response))
		{

			$this->_setAll($url, $response['Value'], $user, $password);

		}
		else
		{

			throw new XenConnectionException("Error during contact Xen, check your credentials (user, password and ip)", 1);

		}
	}

	/**
	 * This parse the xml response and return the response obj
	 *
	 * @param mixed $response ,
	 *
	 *
	 * @return XenResponse
	 */

	function xenrpc_parseresponse($response)
	{


		if (!Validator::arrayType()->validate($response) && !Validator::key('Status')->validate($response))
		{

			return new XenResponse($response);
		}
		else
		{

			if (Validator::key('Status', Validator::equals('Success'))->validate($response))
			{
				return new XenResponse($response);
			}
			else
			{

				if ($response['ErrorDescription'][0] == 'SESSION_INVALID')
				{

					$response = $this->xenrpc_request($this->url, $this->xenrpc_method('session.login_with_password',
						array($this->user, $this->password, '1.3.1')));

					if (Validator::arrayType()->validate($response) && Validator::key('Status', Validator::equals('Success'))->validate($response))
					{
						$this->_setSessionId($response['Value']);
					}
					else
					{
						return new XenResponse($response);
					}
				}
				else
				{
					return new XenResponse($response);

				}
			}
		}


		return new XenResponse($response);
	}


	/**
	 * This encode the request into a xml_rpc
	 *
	 * @param mixed $name the method name and mixed $params the arguments,
	 *
	 *
	 * @return mixed
	 */

	function xenrpc_method($name, $params)
	{

		$encoded_request = xmlrpc_encode_request($name, $params);

		return $encoded_request;
	}


	/**
	 * This make the curl request for comunicate to xen
	 *
	 * @param mixed $usr the url and mixed $req the request,
	 *
	 *
	 * @return XenResponse
	 */

	function xenrpc_request($url, $req)
	{

		$client = new Client();

		$response = $client->post($url,
			[

				'headers' => [
					'Content-type'   => 'text/xml',
					'Content-length' => strlen($req),
				],
				'body'    => $req,
				'timeout' => 60,
				'verify'  => false,

			]);

		$body = $response->getBody();
		$xml  = "";
		while (!$body->eof())
		{
			$xml .= $body->read(1024);
		}


		return xmlrpc_decode($xml);
	}


	/**
	 * This halde every non-declared class method called on XenConnectionObj
	 *
	 * @param mixed $name the name of method and $args the argument of method,
	 *
	 *
	 * @return XenResponse
	 */

	function __call($name, $args)
	{

		if (!Validator::arrayType()->validate($args))
		{
			$args = array();
		}

		list($mod, $method) = explode('__', $name);
		$response = $this->xenrpc_parseresponse($this->xenrpc_request($this->getUrl(),
			$this->xenrpc_method($mod . '.' . $method, array_merge(array($this->getSessionId()), $args))));

		return $response;
	}

}

?>
