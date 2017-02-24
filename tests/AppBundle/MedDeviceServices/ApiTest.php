<?php

namespace AppBundle\Tests\MedDeviceServices;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\MedDeviceServices\Api;

class ApiTest extends KernelTestCase
{
    private $init;
    private $services;
    
    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->services = $this->container->get('services');
    }
    
   
}
