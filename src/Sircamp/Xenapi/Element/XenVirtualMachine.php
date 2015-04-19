<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Connection\XenResponse as  XenResponse;

class XenVirtualMachine extends XenElement {

	private $name;
	private $vmId;

	public function __construct($xenconnection,$name,$vmId){
		parent::__construct($xenconnection);
		$this->name = $name;
		$this->vmId = $vmId;
	}

	/**
	 * Hard Reboot a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function hardReboot(){
		
		return $this->getXenconnection()->VM__hard_reboot($this->getVmId());
	}

	/**
	 * Shutdown a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function hardShutdown(){
		return $this->getXenconnection()->VM__hard_shutdown($this->getVmId());
	}

	/**
	 * Suspend a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function suspend(){
		return $this->getXenconnection()->VM__suspend($this->getVmId());
	}

	/**
	 * Resume a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function resume(){
		return $this->getXenconnection()->VM__resume($this->getVmId());
	}

	/**
	 * Clean Reboot a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function cleanReboot(){
		return $this->getXenconnection()->VM__clean_reboot($this->getVmId());
	}

	/**
	 * Clean Shutdown a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function cleanShutdown(){
		return $this->getXenconnection()->VM__clean_shutdown($this->getVmId());
	}


	/**
	 * Pause a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function pause(){
		return $this->getXenconnection()->VM__pause($this->getVmId());
	}

	/**
	 * UnPause a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function unpuse(){
		return $this->getXenconnection()->VM__unpause($this->getVmId());
	}


	/**
	 * Start a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function start( $pause = false, $force = true){

		return $this->getXenconnection()->VM__start($this->getVmId(),$pause,$force);
	}

	/**
	 * Clone a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	public function clonevm($name){
		return $this->getXenconnection()->VM__clone($this->getVmId(),$name);
	}

	/**
	 * Clone a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getUUID(){
		return $this->getXenconnection()->VM__get_uuid($this->getVmId());
	}
	
	/**
	 * Clone a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getConsoles(){
		return $this->getXenconnection()->VM__get_consoles($this->getVmId());
	}

	/**
	 * Clone a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getConsolesUUID($connection,$CN){
		return $this->getXenconnection()->console__get_uuid($CN);
	}

	/**
	 * Get th VM status by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getPowerState(){
		return $this->getXenconnection()->VM__get_power_state($this->getVmId());
	}


	/**
	 * Get the VM guest metrics by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getGuestMetrics(){
		$VMG = $this->getXenconnection()->VM__get_guest_metrics($this->getVmId());
		return $this->getXenconnection()->VM_guest_metrics__get_record($VMG->getValue());
	}

	/**
	 * Get the VM metrics by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getMetrics(){
		$VMG = $this->getXenconnection()->VM__get_metrics($this->getVmId());
		
		return $this->getXenconnection()->VM_metrics__get_record($VMG->getValue());
	}


	/**
	 * Get the VM stats by passing her uuid.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	function getStats(){

		$user = $this->getXenconnection()->getUser();
		$password = $this->getXenconnection()->getPassword();
		$ip = $this->getXenconnection()->getUrl();
		$uuid = $this->VMGetUUID($this->getVmId());
		
		$url='http://'.$user.':'.$password.'@'.$ip.'/vm_rrd?uuid='.$uuid->getValue().'&start=1000000000‏';

		

		$client = new Client();
		$response = $client->get($url);
		 
		$body = $response->getBody();
        $xml ="";
        
        while (!$body->eof()) {
    		$xml .= $body->read(1024);
		}

		$response = new XenResponse(array('Value'=>array(0=>'')));

		if(Validator::string()->validate($xml)){
			$response = new XenResponse(array('Value'=>$xml,'Status'=>'Success'));
		}
		else{
			$response = new XenResponse(array('Value'=>'', 'Status'=>'Failed'));
		}

		return $response;
	}

	/**
	 * Get the VM disk space by passing her uuid.
	 *
	 * @param mixe $size the currency of size of disk space
	 *
	 * @return XenResponse $response
	 */
	function getDiskSpace($size = NULL){
		$VBD = $this->getXenconnection()->VBD__get_all();
		$memory = 0; 
		foreach ($VBD->getValue() as $bd) {
			$responsevm = $this->getXenconnection()->VBD__get_VM($bd);
			$responsetype = $this->getXenconnection()->VBD__get_type($bd);

			if($responsevm->getValue() == $this->getVmId() && $responsetype->getValue() == "Disk"){
					$VDI = $this->getXenconnection()->VBD__get_VDI($bd);
					$memory += intval($this->getXenconnection()->VDI__get_virtual_size($VDI->getValue())->getValue());	
			}
		}
		
		$response = NULL;
		if(Validator::numeric()->validate($memory)){
			
			return new XenResponse(array('Value'=>$memory,'Status'=>'Success'));
		}
		else{
			return new XenResponse(array('Value'=>0,'Status'=>'Failed'));
		}
		
		return $response;
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
     * Gets the value of vmId.
     *
     * @return mixed
     */
    public function getVmId()
    {
        return $this->vmId;
    }

    /**
     * Sets the value of vmId.
     *
     * @param mixed $vmId the vm id
     *
     * @return self
     */
    private function _setVmId($vmId)
    {
        $this->vmId = $vmId;

        return $this;
    }
}
?>
	