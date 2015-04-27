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

Now you have the an XenVirtualMachine object that map your virtual machine, so we are ready to manage the VM

##### Start VM

```php
$vm->start(); 
```

##### Shutdown VM

```php
$vm->cleanShutdown(); 
```

##### HardShutdown VM

```php
$vm->hardShutdown(); 
```
