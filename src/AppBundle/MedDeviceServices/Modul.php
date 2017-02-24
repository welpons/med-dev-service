<?php


namespace AppBundle\MedDeviceServices;

use AppBundle\MedDeviceServices\Init;
use AppBundle\MedDeviceServices\ServicesInterface;

/**
 * Description of Modul
 *
 * @author jenkins
 */
abstract class Modul
{
    protected $init;
    protected $services;
    
    public function __construct(Init $init, ServicesInterface $services)
    {
        $this->init = $init;
        $this->services = $services;
    }
}
