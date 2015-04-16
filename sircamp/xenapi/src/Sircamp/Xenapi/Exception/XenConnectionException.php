<?php namespace Sircamp\Xenapi\Exception;

use Exception;

class XenConnectionException extends Exception {
	
	public function __construct($message,$code){
		parent::__construct($message,$code);
	}
}

?>