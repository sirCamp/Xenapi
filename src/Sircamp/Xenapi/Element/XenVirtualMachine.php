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
	 * Return a list of all the VMs known to the system.
	 *
	 * @param 
	 *
	 * @return mixed
	 */
	public function getAll(){
		return $this->getXenconnection()->VM__get_all();
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
	 * Awaken the specified VM and resume it on a particular Host. This can only be called when the
	 * specified VM is in the Suspended state.
	 *
	 * @param mixed $VM the uuid of VM, $hostRef the ref of host whic resume the VM
	 *
	 * @return mixed
	 */
	public function resume_on($hostRef = null){
		if($hostRef == null){
			throw new \IllegalArgumentException("hostRef must be not NULL", 1);
			
		}
		return $this->getXenconnection()->VM__resume_on($this->getVmId(),$hostRef);
	}

	/**
	 * Migrate a VM to another Host. This can only be called when the specified VM is in the Running
	 * state.
	 *
	 * @param mixed $VM the uuid of VM, $hostRef the target host
	 *		 $optionsMap  Extra configuration operations
	 * @return mixed
	 */
	
	public function poolMigrate($hostRef = null, $optionsMap = array()){

		return $this->getXenconnection()->VM__pool_migrate($this->getVmId(),$hostRef,$optionsMap);
	}

	/**
	 * Migrate the VM to another host. This can only be called when the specified VM is in the Running
	 * state.
	 *
	 * @param mixed $VM the uuid of VM, 
	 *		  $def The result of a Host.migrate receive call.
	 *		  $live The Live migration
	 *		  $vdiMap of source VDI to destination SR
	 *		  $vifMap of source VIF to destination network
	 *		  $optionsMap  Extra configuration operations
	 * @return mixed
	 */

	public function migrateSend($dest,$live = false,$vdiMap,$vifMap,$options){
		return $this->getXenconnection()->VM__migrate_send($this->getVmId(),$dest,$live,$vdiMap,$vifMap,$options);
	}


	/**
	 * Assert whether a VM can be migrated to the specified destination.
	 *
	 * @param mixed $VM the uuid of VM, 
	 *		  $def The result of a Host.migrate receive call.
	 *		  $live The Live migration
	 *		  $vdiMap of source VDI to destination SR
	 *		  $vifMap of source VIF to destination network
	 *		  $optionsMap  Extra configuration operations
	 * @return mixed
	 */
	public function assertCanMigrate($dest,$live = false,$vdiMap,$vifMap,$options){
		return $this->getXenconnection()->VM__assert_can_migrate($this->getVmId(),$dest,$live,$vdiMap,$vifMap,$options);
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
	 * @param mixed $VM the uuid of VM,
	 *		  $pause Instantiate VM in paused state if set to true.
	 *		  Attempt to force the VM to start. If this flag
	 *		  is false then the VM may fail pre-boot safety
     *         checks (e.g. if the CPU the VM last booted
	 *		  on looks substantially different to the current one)
	 *
	 * @return mixed
	 */
	public function start($pause = false, $force = true){

		return $this->getXenconnection()->VM__start($this->getVmId(),$pause,$force);
	}
	
	/**
	 * Start the specified VM on a particular host. This function can only be called with the VM is in
	 * the Halted State.
	 *
	 * @param mixed $VM the uuid of VM, $hostRef the Host on which to start the VM
	 *		  $pause Instantiate VM in paused state if set to true.
	 *		  Attempt to force the VM to start. If this flag
	 *		  is false then the VM may fail pre-boot safety
     *         checks (e.g. if the CPU the VM last booted
	 *		  on looks substantially different to the current one)
	 *
	 * @return mixed
	 */
	public function startOn($hostRef, $pause = false, $force = true){

		if($hostRef == null){
			throw new \IllegalArgumentException("The where you want start new machine, must be set!", 1);
			
		}
		return $this->getXenconnection()->VM__start_on($this->getVmId(),$hostRef,$pause,$force);
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
	 * Get the UUID of a VM .
	 *
	 * @param 
	 *
	 * @return mixed
	 */
	function getUUID(){
		return $this->getXenconnection()->VM__get_uuid($this->getVmId());
	}
	
	/**
	 * Get the consoles instances a VM by passing her uuid.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	function getConsoles(){
		return $this->getXenconnection()->VM__get_consoles($this->getVmId());
	}

	/**
	 * Get the console UIID of a VM by passing her uuid.
	 *
	 * @param mixed $CN the uuid of conosle of VM
	 *
	 * @return mixed
	 */
	function getConsoleUUID($CN){
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
	 * Reset the power-state of the VM to halted in the database only. (Used to recover from slave failures
	 * in pooling scenarios by resetting the power-states of VMs running on dead slaves to halted.) This
	 *  is a potentially dangerous operation; use with care.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function powerStateReset(){
		return $this->getXenconnection()->VM__power_state_reset($this->getVmId());
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

    /**
     * Snapshots the specified VM, making a new VM. 
     * Snapshot automatically exploits the capabilities of the underlying storage repository 
     * in which the VM’s disk images are stored
     *
     * @param string $name the name of snapshot
     *
     * @return XenResponse $response
     */
    public function snapshot($name){
		return $this->getXenconnection()->VM__snapshot($this->getVmId(),$name);
	}

	//TOFIX
	/**
	 * Snapshots the specified VM with quiesce, making a new VM. 
	 * Snapshot automatically exploits the capabilities of the underlying 
	 * storage repository in which the VM’s disk images are stored
	 *
	 * @param string $name the name of snapshot
	 *
	 * @return XenResponse $response
	 */
	public function snapshotWithQuiesce($name){
		return $this->getXenconnection()->VM__snapshot_with_quiesce($this->getVmId(),$name);
	}

	/**
	 * Get the snapshot info field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getSnapshotInfo($name){
		return $this->getXenconnection()->VM__get_snapshot_info($this->getVmId());
	}
	

	/**
	 * Copied the specified VM, making a new VM. Unlike clone, copy does not exploits the capabilities
	 * of the underlying storage repository in which the VM’s disk images are stored. Instead, copy
	 * guarantees that the disk images of the newly created VM will be ’full disks’ - i.e. not part of a
	 * CoW chain. This function can only be called when the VM is in the Halted State
	 *
	 * @param string $name the name of new vm
	 *
	 * @return XenResponse $response
	 */
	public function copy($name){
		return $this->getXenconnection()->VM__copy($this->getVmId(),$name,"");
	}


	/**
	 * Destroy the specified VM. The VM is completely removed from the system. This function can
	 * only be called when the VM is in the Halted State.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function destroy(){
		return $this->getXenconnection()->VM__destroy($this->getVmId());
	}
	/**
	 * Reverts the specified VM to a previous state
	 *
	 * @param string $name the name of snapshot
	 *
	 * @return XenResponse $response
	 */
	public function revert($snapshotID){
		return $this->getXenconnection()->VM__revert($this->getVmId(),$snapshotID);
	}

	/**
	 * Checkpoints the specified VM, making a new VM. Checkpoint automatically exploits the capabil-
	 * ities of the underlying storage repository in which the VM’s disk images are stored (e.g. Copy on
	 * Write) and saves the memory image as well
	 *
	 * @param string $name the name of new VPS
	 *
	 * @return XenResponse $response
	 */
	public function checkpoint($name){
		return $this->getXenconnection()->VM__checkpoint($this->getVmId(),$name);
	}


	/**
	 * Set this VM’s start delay in seconds.
	 *
	 * @param int seconds of delay
	 *
	 * @return XenResponse $response
	 */
	public function setStartDelay($seconds){
		return $this->getXenconnection()->VM__set_start_delay($this->getVmId(),$seconds);
	}
	
	/**
	 * Set this VM’s start delay in seconds.
	 *
	 * @param int seconds of delay
	 *
	 * @return XenResponse $response
	 */
	public function setShutdownDelay($seconds){
		return $this->getXenconnection()->VM__set_shutdown_delay($this->getVmId(),$seconds);
	}

	/**
	 * Get the start delay field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getStartDelay(){
		return $this->getXenconnection()->VM__get_start_delay($this->getVmId());
	}
	
	/**
	 * Get the shutdown delay field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getShutdownDelay(){
		return $this->getXenconnection()->VM__get_shutdown_delay($this->getVmId());
	}

	/**
	 * Get the current operations field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations(){
		return $this->getXenconnection()->VM__get_current_operations($this->getVmId());
	}

	/**
	 * Get the allowed operations field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations(){
		return $this->getXenconnection()->VM__get_allowed_operations($this->getVmId());
	}



	/**
	 * Get the name/description field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription(){
		return $this->getXenconnection()->VM__get_name_description($this->getVmId());
	}

	/**
	 * Set the name/description field of the given VM.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name){
		return $this->getXenconnection()->VM__set_name_description($this->getVmId(),$name);
	}

	/**
	 * Get the is a template field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getIsATemplate(){
		return $this->getXenconnection()->VM__get_is_a_template($this->getVmId());
	}

	/**
	 * Set the is a template field of the given VM.
	 *
	 * @param bool $template
	 *
	 * @return XenResponse $response
	 */
	public function setIsATemplate($template){
		return $this->getXenconnection()->VM__set_is_a_template($this->getVmId(),$template);
	}



	/**
	 * Get the resident on field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getResidentOn(){
		return $this->getXenconnection()->VM__get_resident_on($this->getVmId());
	}

	/**
	 * Get the platform field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getPlatform(){
		return $this->getXenconnection()->VM__get_platform($this->getVmId());
	}


	/**
	 * Set the platform field of the given VM.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setPlatform($value = array()){
		return $this->getXenconnection()->VM__set_platform($this->getVmId(),$value);
	}	
	

	/**
	 * Get the other config field of the given VM.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig(){
		return $this->getXenconnection()->VM__get_other_config($this->getVmId());
	}
	
	/**
	 * Set the other config field of the given VM.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array()){
		return $this->getXenconnection()->VM__set_other_config($this->getVmId(),$array);
	}

	/**
	 * Add the given key-value pair to the other config field of the given vm.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToOtherConfig($key,$value){
		return $this->getXenconnection()->VM__add_to_other_config($this->getVmId(),$key,$value);
	}
	
	/**
	 * Remove the given key and its corresponding value from the other config field of the given vm. If
     * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key){
		return $this->getXenconnection()->VM__remove_from_other_config($this->getVmId(),$key);
	}
}
?>
	