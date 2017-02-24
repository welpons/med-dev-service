<?php

/*
 * Copyright (C) 2017 Welpons <welpons@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tests\MedicalDevicesBundle\Framework;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Configuration\ConfigurationInterface;

/**
 * Description of ConfigFactoryTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class ConfigFactoryTest extends KernelTestCase
{

    private $container;
    private $init;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
    }

    /**
     * @test
     * @group meddevicesbundle_framework_configfactory
     */
    public function checkInstance()
    {
        $this->assertTrue($this->init instanceof ConfigurationInterface);
    }     
    
    /**
     * @test
     * @group meddevicesbundle_framework_configfactory
     */
    public function hasParameter()
    {
        $this->assertTrue($this->init->hasParameter('application.identifier_types'));
    }  
       
    /**
     * @test
     * @group meddevicesbundle_framework_configfactory
     */
     public function getParameterAssociativeArray()
     {
         $configParam = $this->init->getParameter('application.identifier_types');
        
         $this->assertTrue(is_array($configParam) && 4 == count($configParam));
         $this->assertEquals('SNO', $this->init->getParameter('application.identifier_types.serial_number'));
     }        
     
    /**
     * @test
     * @group meddevicesbundle_framework_configfactory
     * @expectedException MedicalDevices\Configuration\UndefinedParameterException
     */
     public function getUndefinedParameter()
     {
         $configParam = $this->init->getParameter('application.undefined_param');
     }        
     
    /**
     * @test
     * @group meddevicesbundle_framework_configfactory
     * @expectedException MedicalDevices\Configuration\UndefinedParameterException
     */
     public function getUndefinedParameterGroup()
     {
         $configParam = $this->init->getParameter('undefined_param');
     }          
}
