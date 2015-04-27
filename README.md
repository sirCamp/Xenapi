# Xenapi for PHP

A Xen PHP API for managment of Hypervisor and Citrix Server and their Virtual Machines for PHP, it works on Laravel 4, Laravel 5, Codeigniter and other PHP framework.
Before install this library make sure to have installed *xmlrpc php* module

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
$vm = $xen->getVMByNameLabel("virtual.machine.hostanme");
```

#### Virtual Machine Managment

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