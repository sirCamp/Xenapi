# Xenapi for PHP

A Xen PHP API for managment of Hypervisor and Citrix Server and their Virtual Machines for PHP, it works on Laravel 4, Laravel 5, Codeigniter and other PHP framework.
Before install this library make sure to have installed *xmlrpc php* module

API in PHP to communicate with Xen Server . 
This packages is available on Composer's repositories .
The package Allows to completely Manage an Hypervisvor Citrix .
With this , you can clone , start , stop and reboot any VPS of your Hypervisor
Also, this APi allow you toi have a realtime graph of your Hypervisor's VPS!
I've create the Method that obtain XML realtime stats of Machine and convert it to RRD file, needed for the FlotJS library to draw the graph.
This API is available for all the major PHP Frameworks, such as Laravel, Symfony or Codeigniter.

## Table Of Contents

1. [Installation](#installation)
2. [Documentation](#documentation)
	+ [Namespace Import](#namespace-import)
	+ [Connect With an Hypervisor](#connect-with-an-hypervisor)
	+ [Get Virtual Machine](#get-virtual-machine)
	+ [Virtual Machine Managment](#virtual-machine-managment)
	+ [Get Host](#get-host)
	+ [Host Management](#host-management)
	+ [Response Management](#response-management)
	+ [Exceptions](#exceptions)

## Installation :

Package is available on [Packagist](https://packagist.org/packages/sircamp/xenapi),
you can install it using [Composer](http://getcomposer.org).

In the **require** key of **composer.json** file add the following:

```php
"sircamp/xenapi": "2.1"
```
Or type this command from your project folder

```bash
composer require sircamp/xenapi
```

## Documentation: 

#### Namespace Import
Sircamp\Xenapi is namespaced, but you can make your life easier by importing
a single class into your context:

```php
use Sircamp\Xenapi\Xen as Xen;
```

#### Connect With an Hypervisor

Make sure that you have IP, User and Password of your hypervisor:

```php
$ip = "123.123.123.123";
$user = "username";
$password = "password";
$xen = new Xen($ip,$user,$password); //OK now you have an open connection to Hypervisor
```

#### Get Virtual Machine 

This serves to have a virtual machine (by the hostname) that is on selected hypervisor :

```php
$vm = $xen->getVMByNameLabel("virtual.machine.hostaname");
```


#### Virtual Machine Management

Now you have the an XenVirtualMachine object that map your virtual machine, so we are ready to manage the VM

##### Start VM

This method starts a stopped VM

```php
$vm->start(); 
```
You can, also, pass two parameters at this method:
```php
$pause = true; // start VM in pause status , dafault is false
$force = true; // force the boot of VM, default is true
$vm->start($pause, $force); 
```

##### StartOn VM

This method starts the specified VM on a particular host. This function can only be called with the VM is in the Halted State.
*This method needs an XenHost object as parameter, but if you want you can pass a UUID host string*

```php
$host // this is a XenHost object istance or a string istance
$hostRef = $host;
$pause = true; // start VM in pause status , dafault is false
$force = true; // force the boot of VM, default is true
$vm->startOn($hostRef,$pause, $force); 
```

##### Shutdown VM

This method sends a shutdown command to the Virtual Machine

```php
$vm->cleanShutdown(); 
```

##### Hard Shutdown VM
This method immediatly a shutdown  the Virtual Machine

```php
$vm->hardShutdown(); 
```

##### Reboot VM
This method sends a reboot command to the Virtual Machine
```php
$vm->cleanShutdown(); 
```

##### Hard Reboot VM

This method immediatly restarts  the Virtual Machine

```php
$vm->hardShutdown(); 
```

##### Suspend VM

This method puts Virtual Machine in a suspend mode (read the Citrix manual)

```php
$vm->suspend(); 
```

##### Resume VM

This method resumes a Virtual Machine that is in a suspend mode (read the Citrix manual)

```php
$vm->resume(); 
```
##### ResumeOn VM

This method awaken the specified VM and resume it on a particular Host. This can only be called when the specified VM is in the Suspended state.
*This method needs an XenHost object as parameter, but if you want you can pass a UUID host string*

```php
$host // this is a XenHost object istance or a string istance
$hostRef = $host;
$vm->resumeOn($hostRef); 
```

##### Pause VM

This method puts a Virtual Machine in pause 

```php
$vm->pause(); 
```

##### Unpause VM

This method restores a Virtual Machine that is in pause

```php
$vm->unpause(); 
```

##### Clone VM

This method clones the selected Virtual Machine into another ( please check if your hypervisor supports another machine).

before this, you must stop the virtual machine that you want clone

```php
$name = "new_cloned_vm"; // name of cloned vm
$vm->cleanShudown(); // stop  vm
$vm->clonevm($name); 
```

##### Power Status of VM

This method gets the power status of the selected Virtual Machine 

```php
$vm->getPowerState();
```

##### Power State Reset of VM

Reset the power-state of the VM to halted in the database only. (Used to recover from slave failures in pooling scenarios by resetting the power-states of VMs running on dead slaves to halted.) This  is a potentially dangerous operation; use with care.

```php
$vm->powerStateReset();
```

##### UUID of VM

This method obtains the UUID of the selected Virtual Machine.


```php
$vm->getUUID();
```

##### Consoles of VM

This method returns the all console instances of  selected Virtual Machine.
The console istance allows you to have  and manage a SSH or RDP session of Virtual Machine


```php
$vm->getConsoles()
```
##### UUID of VM Console

This method returns the UUID of selected Virtual Machine's console.
The UUID is very usefull for console istance mangement.

```php
$vm->getConsoleUUID($console)
```

##### Guest Metrics of VM

This method returns the guest metrics of selected Virtual Machine.
This metrics contains:

+ uuid
+ os_version (name, uname, distro, relase version)
+ memory
+ disks
+ networks
+ other

*in the future, i will write an example*

```php
$vm->getGuestMetrics()
```


##### Metrics of VM

This method returns the metrics of selected Virtual Machine.
This metrics contains:

+ uuid
+ memory_actual
+ VCPUs_number
+ VCPUs_utilisation

*as for guest metrics, in the future, i will write an example*

```php
$vm->getMetrics()
```
##### Statistics of VM 

This method returns the current stats of the running selected Virtual Machine.
With this method, you can obtain the stats of  CPUs, RAM and DISK I/O  in ***realtime***!

However, this method return an response object that contains a XML string in the ***value*** attribute.
Inside this XML string you find the required statistics.

*as for last two methods, in the future, i will write an example. Also, i would to show you how to obtain a realtime stats graph, stay tuned ;)*

```php
$vm->getStats()
```
##### Disks Total Space of VM

This method returns the total amount of Virtual Machine's Disks space.
Actually this method return the total in bytes.

```php
$vm->getDiskSpace()
```
Also, you can pass an argument:

```php
$format = "GB";
$vm->getDiskSpace($format);
```
This allow you to have the disk space in the format as you want.
**NB: this feature is not yet implemented**

##### Name of VM
This method returns the name of VM

```php
$vm->getName()
```

##### GetAll VMs
This method returns a list of all the VMs known to the system.

```php
$vm->getAll()
```

##### PoolMigrate  VM
Migrate a VM to another Host. This can only be called when the specified VM is in the Running state.
*This method needs an XenHost object as parameter, but if you want you can pass a UUID host string*
The *optionsMap* parameter is a map that contains the options for pool migrating.

```php
$optionsMap = array(
	'option1' => "option first",
	'option2' => "option second"
)
$host // this is a XenHost object istance or a string istance
$hostRef = $host;
$vm->poolMigrate($refHost, $optionsMap);
```

##### MigrateSend  VM
Assert whether a VM can be migrated to the specified destination.
In this method the first parameter, *dest*, is the result of a **Host.migrate** receive call.
The *vdiMap* parameter is the map of source VDI to destination SR.
The *vifMap* parameter is the map of VIF to destination network.
The *optionsMap*  Extra configuration operations.
The *live* parameter allows to migrate the VM in *live mode* or nothing, on default this paramter is set to *false*.

```php
$dest // Host.migrate call result
$vdiMap //map of source VDI
$vifMap //map of source VFI
$options = array(
	'option1' => "option first",
	'option2' => "option second"
);
$live = true;
$vm->migrateSend($dest,$vdiMap,$vifMap,$options,$live)
```
**NB: this method is still in testing mode**

##### AssertCanMigrate  VM
Assert whether a VM can be migrated to the specified destination.
In this method the first parameter, *dest*, is the result of a **Host.migrate** receive call.
The *vdiMap* parameter is the map of source VDI to destination SR.
The *vifMap* parameter is the map of VIF to destination network.
The *optionsMap*  Extra configuration operations.
The *live* parameter allows to migrate the VM in *live mode* or nothing, on default this paramter is set to *false*.

```php
$dest // Host.migrate call result
$vdiMap //map of source VDI
$vifMap //map of source VFI
$options = array(
	'option1' => "option first",
	'option2' => "option second"
);
$live = true;
$vm->assertCanMigrate($dest,$vdiMap,$vifMap,$options,$live)
```
**NB: this method is still in testing mode**

##### Snapshot of VM
Snapshots the specified VM, making a new VM. Snapshot automatically exploits the capabilities of the underlying storage repository in which the VM’s disk images are stored

```php
$name = "name of snapshot";
$vm->snapshot($name)
```

##### Snapshot of VM
Snapshots the specified VM with quiesce, making a new VM. 
Snapshot automatically exploits the capabilities of the underlying storage repository in which the VM’s disk images are stored

```php
$name = "name of snapshot";
$vm->snapshotWithQuiesce($name)
```
##### GetSnapshot of VM
Get the snapshot info field of the given VM.

```php
$vm->getSnapshotInfo()
```

##### Revert of VM
Reverts the specified VM to a previous state

```php
$snapshotID // the snaoshot id
$vm->revert($snapshotID)
```

##### Copy VM
Copied the specified VM, making a new VM. Unlike clone, copy does not exploits the capabilities of the underlying storage repository in which the VM’s disk images are stored. Instead, copy guarantees that the disk images of the newly created VM will be ’full disks’ - i.e. not part of a  CoW chain. This function can only be called when the VM is in the Halted State

```php
$name = "nameOfCopy";
$vm->copy($name);
```

##### Destroy VM
Destroy the specified VM. The VM is completely removed from the system. This function can only be called when the VM is in the Halted State.

```php
$vm->destroy();
```

##### Checkpoints of VM
Checkpoints the specified VM, making a new VM. Checkpoint automatically exploits the capabil-ities of the underlying storage repository in which the VM’s disk images are stored (e.g. Copy on Write) and saves the memory image as well

```php
$name = "nameOfVM";
$vm->checkpoint($name);
```

##### SetStartDelay of VM
Set this VM’s start delay in seconds.

```php
$seconds = 5;
$vm->setStartDelay($seconds);
```

##### SetShutdownDelay of VM
Set this VM’s start delay in seconds.

```php
$seconds = 5;
$vm->setShutdownDelay($seconds);
```

##### GetStartDelay of VM
Get this VM’s start delay in seconds.

```php
$vm->getStartDelay();
```

##### GetShutdownDelay of VM
Get this VM’s start delay in seconds.

```php
$vm->getShutdownDelay();
```
##### GetCurrentOperations of VM
Get the current operations field of the given VM.

```php
$vm->getCurrentOperations();
```
##### GetAllowedOperations of VM
Get the allowed operations field of the given VM.

```php
$vm->getAllowedOperations();
```
##### GetNameDescription of VM
Get the name/description field of the given VM.

```php
$vm->getNameDescription();
```

##### SetNameDescription of VM
Set the name/description field of the given VM.

```php
$description = "description";
$vm->setNameDescription($description);
```

##### GetIsATemplate of VM
Get the is a template field of the given VM.

```php
$vm->getIsATemplate();
```

##### SetIsATemplate of VM
Set the is a template field of the given VM.

```php
$template = false;
$vm->setIsATemplate($template);
```

##### GetResidentOn of VM
Get the resident on field of the given VM.
In the response of this method you’ll find a XenHost object that you can use.

```php
$vm->getResidentOn();
```
##### GetPlatform of VM
Get the platform field of the given VM.

```php
$vm->getPlatform();
```

##### SetPlatform of VM
Set the platform field of the given VM.

```php
$array = array(
	'data'=>'value',
	'data2'=>'value'
);
$vm->setPlatform($array);
```
	
##### GetOtherConfig of VM
Get the other config field of the given VM.

```php
$vm->getOtherConfig();
```

##### SetOtherConfig of VM
Set the other config field of the given VM.

```php
$array = array(
	'config'=>'value',
	'config2'=>'value'
);
$vm->setOtherConfig($array);
```

##### AddToOtherConfig of VM
Set the other config field of the VM given key-value pair to the other config field of the given vm.

```php
$key = "key";
$value = "value"

$vm->addToOtherConfig($key, value);
```

##### RemoveFromOtherConfig of VM
Remove the given key and its corresponding value from the other config field of the given vm. If the key is not in that Map, then do nothing.

```php
$key = "key";
$value = "value"

$vm->removeFromOtherConfig($key);
```

##### GetNameLabel of VM
Get name label VM.

```php
$vm->getNameLabel();
```

#### Get Host

This serves to obtain the target host (by the hostname) :

```php
$host = $xen->getHOSTByNameLabel("host.machine.hostaname");
```

#### Host Management

Now you have the an XenHost object that map your hypervisor, so we are ready to manage the HOST

##### Disable HOST
Puts the host into a state in which no new VMs can be started. Currently active VMs on the host continue to execute.
```php
$host->disable()
```
##### Enable HOST
Puts the host into a state in which  new VMs can be started.
```php
$host->enable()
```
##### Shutdown HOST
Shutdown the host. (This function can only be called if there are no currently running VMs on the host and it is disabled.).

```php
$host->shutdown()
```
##### Reboot HOST
Reboot the host. (This function can only be called if there are no currently running VMs on the host and it is disabled.).

```php
$host->reboot()
```
##### Dmesg of HOST
Get the host xen dmesg.

```php
$host->dmesg()
```
##### DmesgClear of HOST
Get the host xen dmesg, and clear the buffer

```php
$host->dmesgClear()
```
##### GetLog of HOST
Get the host’s log file.

```php
$host->getLog()
```
##### ListMethods of HOST
List all supported methods.

```php
$host->listMethods()
```

##### LicenseApply of HOST
Apply a new license to a host.
The default value of *$license* is an empty string

```php
$file = file_get_contents("/path/license/file");
$license = base64_encode($file);
$host->licenseApply($license)
```
**NB: $license must be an base64 encoded file**


##### AssertCanEvacuate  HOST
Check this host can be evacuated.

```php
$host->assertCanEvacuate()
```
  
##### Evacuate  HOST
Migrate all VMs off of this host, where possible.

```php
$host->evacuate()
```  

##### GetServerTime of HOST
This call queries the host’s clock for the current time.

```php
$host->getServertime()
```     

##### GetServerLocaltime of HOST
This call queries the host's clock for the current time in the host’s local timezone.

```php
$host->getServerLocaltime()
```
##### GetServerCertificate of HOST
Get the installed server SSL certificate.

```php
$host->getServerCertificate()
```
**NB: This method returns the SSL certificate in .pem format**

##### ApplyEdition of HOST
Change to another edition, or reactivate the current edition after a license has expired. This may be subject to the successful checkout of an appropriate license.
Default *$force* param is *false*, this means which you want force an update edition.

```php
$edition = "newedition";
$force = true;
$host->getServerCertificate()
```
##### RefreshPackInfo of HOST
Refresh the list of installed Supplemental Packs.

```php
$host->refreshPackInfo()
```
    
##### EnableLocalStorageCaching of HOST
Enable the use of a local SR for caching purposes.

```php
$srRef = "srReferID";
$host->enableLocalStorageCaching($srRef);
```

##### DisableLocalStorageCaching of HOST
Disable the use of a local SR for caching purposes. 

```php
$host->disableLocalStorageCaching();
```

##### MigrateReceive of HOST
Prepare to receive a VM, returning a token which can be passed to *VM->migrate().*
The *$features* is an associative array that cotains the configuration value that you need to run the migrating machine, it default value is an *empty* array.

```php
$networkRef = "networkRef" // shorty you can pass the obeject that map network
$features = array(
	'options1'=>"youroption",
	'options2'=>"youroption",
);
$host->migrateReceive($networkRef, $features);
```
##### GETUUID of HOST
Get the uuid field of the given host. 	

```php
$host->getUUID()
```

##### GetNameLabel of HOST
Get the name/label field of the given host. 	

```php
$host->getNameLabel()
```
##### SetNameLabel of HOST
Set the name/label field of the given host. 	

```php
$name = "server.yourname.com";
$host->setNameLabel($name);
```   

##### GetNameDescription of HOST
Get the name/description field of the given HOST.	

```php
$host->getNameDescription()
```
##### SetNameDescription of HOST
Set the name/description field of the given HOST.	

```php
$description = "long long text";
$host->setNameDescription($description)
```
##### SetNameDescription of HOST
Set the name/description field of the given HOST.	

```php
$description = "long long text";
$host->setNameDescription($description)
```
##### GetAllowedOperations of HOST
Get the allowed operations field of the given HOST.	

```php
$host->getAllowedOperations()
```

##### GetSoftwareVersion of HOST
Get the software version field of the given host.	

```php
$host->getSoftwareVersion()
```

##### GetOtherConfig of HOST
 Get the other config field of the given HOST.	

```php
$host->getOtherConfig()
```
##### SetOtherConfig of HOST
 Set the other config field of the given HOST.	

```php
$config = array(
	'config1' => "first config",
	'config2' => "second config"
);
$host->setOtherConfig($config)
```

##### AddOtherConfig of HOST
Add the given key-value pair to the other config field of the given host.	

```php
$key = "config1";
$value = "first config";
$host->addOtherConfig($key,$value)
```
##### RemoveOtherConfig of HOST
Remove the given key and its corresponding value from the other config field of the given host. *If the key is not in that Map, then do nothing.*

```php
$key = "config1";
$host->removeOtherConfig($key)
```

##### GetSupportedBootloaders of HOST
Get the supported bootloaders field of the given host.	

```php
$host->getSupportedBootloaders()
```
##### GetResidentVMs of HOST
Get the resident VMs field of the given host.
In the response of this method you'll find, if there exists at least a VM inside this Host, an array of VMs object that you can use.	

```php
$host->getResidentVMs()
```
##### GetPatches of HOST
Get the patches field of the given host.

```php
$host->getPatches()
```

##### GetHostCPUs of HOST
Get the host CPUs field of the given host.

```php
$host->getHostCPUs()
```
##### GetCPUInfo of HOST
Get the cpu info field of the given host.

```php
$host->getCPUInfo()
```
##### GetHostname of HOST
Get the hostname of the given host.

```php
$host->getHostname()
```
##### SetHostname of HOST
Set the hostname of the given host.

```php
$name = "new.hostname.com"
$host->setHostname($name);
```
##### GetAddress of HOST
Get the address field of the given host.

```php
$host->getAddress()
```

##### SetAddress of HOST
Set the address field of the given host. 

```php
$address = "123.123.123.123"
$host->setAddress($address);
```

##### GetMetrics of HOST
Get the metrics field of the given host.

```php
$host->getMetrics()
```
	
##### GetLicenseParam of HOST
Get the license params field of the given host.

```php
$host->getLicenseParam()
```
##### GetEdition of HOST
Get the edition field of the given host. 

```php
$host->getEdition()
```

##### GetLicenseServer of HOST
Get the license server field of the given host.

```php
$host->getLicenseServer()
```
##### SetLicenseServer of HOST
Set the license server field of the given host.

```php
$license = "newlicense"
$host->setLicenseServer($license);
```
##### AddToLicenseServer of HOST
Add the given key-value pair to the license server field of the given host.

```php
$key = "licenseName";
$value = "licenseValue";
$host->addToLicenseServer($key,$value);
```

##### RemoveFromLicenseServer of HOST
Remove the given key and its corresponding value from the license server field of the given host. *If the key is not in that Map, then do nothing.*

```php
$key = "licenseName";
$host->removeFromLicenseServer($key);
```

##### GetChipsetInfo of HOST
Get the chipset info field of the given host.

```php
$host->getChipsetInfo()
```
#### Response Management

Every method return an istance of *XenResponse* class.
This object contains three attributes:

+ Value
+ Status
+ ErrorDescription

##### Value attribute
This attribute contains the value of response, sach as message, XML string or something else.

use this method to obtain it:
```php
$response = $vm->hardReboot();
$response->getValue();
```
##### Status attribute
This attribute contains the status of response.
If status is **Success** the request is OK.
Otherwise is request is KO, use this for check the result of your operations

use this method to obtain it:
```php
$response = $vm->hardReboot();
$response->getStatus();
```
##### ErrorDescription attribute
This attribute contains message of KO response.
Just take the value of this attribute and check why the response isn't OK.

For example if your connection credentials are wrong:
```php
$console = "wrong_console";
$response = $vm->getConsolesUUID($console);
$response->getStatus(); //return Failure
$response->getErrorDescription(); // return an array with some error message
```

#### Exceptions

This is exaplained the custom excetions

##### XenConnectionException

This exception is launched when you try to connect to a hypervisor with a wrong credentials.

To catch this exception, remember to use the namespace of this class:
```php
use Sircamp\Xenapi\Exception\XenConnectionException as XenConnectionException;
```
