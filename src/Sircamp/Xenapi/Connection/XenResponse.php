<?php namespace Sircamp\Xenapi\Connection;

use ReflectionClass;
use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;

class XenResponse {
	
	private $Value;
	private $Status;
	private $ErrorDescription = array();
	
	public function __construct($args){

		foreach ($args as $key => $argument) {
			$class = new ReflectionClass('Sircamp\Xenapi\Connection\XenResponse');
			$property  = $class->getProperty($key);
			$property->setAccessible( true );
			$property->setValue($this, $argument);
			
		}

	}

    /**
     * Gets the value of Value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * Sets the value of Value.
     *
     * @param mixed $Value the value
     *
     * @return self
     */
    public function _setValue($Value)
    {
        $this->Value = $Value;

        return $this;
    }

    /**
     * Gets the value of Status.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * Sets the value of Status.
     *
     * @param mixed $Status the status
     *
     * @return self
     */
    private function _setStatus($Status)
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * Gets the value of ErrorDescription.
     *
     * @return mixed
     */
    public function getErrorDescription()
    {
        return $this->ErrorDescription;
    }

    /**
     * Sets the value of ErrorDescription.
     *
     * @param mixed $ErrorDescription the error description
     *
     * @return self
     */
    private function _setErrorDescription($ErrorDescription)
    {
        $this->ErrorDescription = $ErrorDescription;

        return $this;
    }
}

?>