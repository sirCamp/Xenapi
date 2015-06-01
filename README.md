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
"sircamp/xenapi": "1.0"
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
This method return the name of VM

```php
$vm->getName()
```

#### Get Host

This serves to obtain the target host (by the hostname) :

```php
$host = $xen->getHOSTByNameLabel("host.machine.hostaname");
```

#### Host Management

Now you have the an XenHost object that map your hypervisor, so we are ready to manage the HOST

#####Disable HOST
Puts the host into a state in which no new VMs can be started. Currently active VMs on the host continue to execute.
```php
$host->disable()
```
#####Enable HOST
Puts the host into a state in which  new VMs can be started.
```php
$host->enable()
```
#####Shutdown HOST
Shutdown the host. (This function can only be called if there are no currently running VMs on the host and it is disabled.).

```php
$host->shutdown()
```
#####Reboot HOST
Reboot the host. (This function can only be called if there are no currently running VMs on the host and it is disabled.).

```php
$host->reboot()
```
#####Dmesg of HOST
Get the host xen dmesg.

```php
$host->dmesg()
```
#####DmesgClear of HOST
Get the host xen dmesg, and clear the buffer

```php
$host->dmesgClear()
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
