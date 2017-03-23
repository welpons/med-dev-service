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

namespace Tests\MedicalDevices\Application\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use MedicalDevices\Application\Service\ApplicationService;
use MedicalDevices\Configuration\ConfigurationInterface;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Application\Service\Device\AddDeviceWithReferenceIdentifierService;

/**
 * Description of ApplicationServiceTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class ApplicationServiceTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;
    private $init;
    private $repositoriesProvider;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->repositoriesProvider = $this->container->get('repository.collection.provider');
    }    
    
    /**
     * @test
     * @group application_service_device_deviceidentifiervalidator
     */
    public function validateDeviceIdentifier()
    {
//        $service = new AddDeviceWithReferenceIdentifierService($this->init, $this->repositories);
//        $this->assertTrue($service instanceof ApplicationService);
        
        $stub = $this->getMockBuilder(ApplicationService::class)
        ->setConstructorArgs(array($this->init, $this->repositoriesProvider))
        ->getMockForAbstractClass();  
        
        $this->assertTrue($stub instanceof ApplicationService);
    }        
    
}
