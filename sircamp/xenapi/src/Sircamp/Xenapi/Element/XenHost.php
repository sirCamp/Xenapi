<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;

class XenHost extends XenElement {

	private $name;
	private $uuid;

	public function __construct($xenconnection,$name,$uuid){
		parent::__construct($xenconnection);
		$this->name = $name;
	}
}
?>
	