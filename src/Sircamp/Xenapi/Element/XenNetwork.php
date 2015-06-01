<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;

class XenNetwork extends XenElement {

	private $name;
	private $networkId;

	public function __construct($xenconnection,$name,$networkId){
		parent::__construct($xenconnection);
		$this->name = $name;
		$this->networkId = $hostId;
	}

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    private function _setName($name)
    {
        $this->name = $name;

        return $this;
    }

	/**
	 * Return a list of all the Networks known to the system.
	 *
	 * @param 
	 *
	 * @return mixed
	 */
	public function getAll(){
		return $this->getXenconnection()->network__get_all();
	}
}
?>
	