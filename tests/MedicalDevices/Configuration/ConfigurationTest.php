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

namespace Tests\MedicalDevices\Configuration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use MedicalDevices\Configuration\ConfigurationInterface;

/**
 * Description of ConfigurationTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class ConfigurationTest extends KernelTestCase
{
    private $container;
    private $init;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
    }  
    
    /**
     * @test
     * @group configuration
     */
    public function implementsInterface()
    {
        $this->assertTrue($this->init instanceof ConfigurationInterface);
    }        
    
    /**
     * @test
     * @group configuration
     */
    public function setParameter()
    {
        $this->init->setParameter('application.validators.invalid_validator', "Tests\MedicalDevices\Application\Service\Validation\\InvalidValidator");
        
        $this->assertEquals($this->init->getParameter('application.validators.invalid_validator'), "Tests\MedicalDevices\Application\Service\Validation\\InvalidValidator"); 
    }        
}
