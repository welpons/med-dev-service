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

namespace Tests\MedicalDevices\Application\Service\Device;

use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use MedicalDevices\Application\Service\Device\AddDeviceWithReferenceIdentifierService;
use MedicalDevices\Application\Service\Device\DeviceDTO;
use MedicalDevices\Application\Service\ApplicationService;
use MedicalDevices\Application\Service\Device\AddDeviceWithReferenceIdentifierServiceCommandInterface;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceRepository;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceIdentifierRepository;
use Tests\MedicalDevices\Infrastructure\Persistence\Doctrine\LoadDeviceData;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;

/**
 * Description of AddDeviceWithReferenceIdentifierServiceTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class AddDeviceWithReferenceIdentifierServiceTest extends KernelTestCase
{
    private $em;
    private $container;
    private $init;
    private $repositories;
    private $validationHandler;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->repositories = $this->container->get('repository.collection.provider')->getCollection();
        $this->validationHandler = $this->container->get('ext.services.validation.error.handler');
        
        $application = new App(static::$kernel);
        $this->container = static::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
        $this->doctrineDeviceRepository = new DoctrineDeviceRepository($this->em);
        $this->doctrineDeviceIdentifierRepository = new DoctrineDeviceIdentifierRepository($this->em);
        
        $commandDrop = $application->find('doctrine:schema:drop');
        $commandTesterDrop = new CommandTester($commandDrop);
        $commandTesterDrop->execute(array('command' => $commandDrop->getName(), '--env' => 'test', '--force' => true));
 
        $commandCreate = $application->find('doctrine:schema:create');
        $commandTesterCreate = new CommandTester($commandCreate);
        $commandTesterCreate->execute(array('command' => $commandCreate->getName(), '--env' => 'test'));  
        
        $fixture = new LoadDeviceData();
        $fixture->load($this->em);          
    }   

    /**
     * @test
     * @group application_service_adddevicewithreferenceidentifier
     */
    public function instantiateService()
    {
        $device = new AddDeviceWithReferenceIdentifierService($this->init, $this->repositories);
        $this->assertTrue($device instanceof ApplicationService);
        $this->assertTrue($device instanceof AddDeviceWithReferenceIdentifierServiceCommandInterface);
    }        
    
    /**
     * @test
     * @group application_service_adddevicewithreferenceidentifier1
     */
    public function addDeviceToSystem()
    {
        $dto = new DeviceDTO('med', 'GLUCO', 'FORA_D40', 'SNO', 'SNA78G56');
        
        $device = new AddDeviceWithReferenceIdentifierService($this->init, $this->repositories);
        $device->execute($this->validationHandler, $dto);
        $this->assertFalse($this->validationHandler->hasErrors());
        
        $persistedDevice = $this->doctrineDeviceRepository->deviceOfId($device->id());
        $this->assertTrue($persistedDevice instanceof Device);
        
        $persistedDeviceIdentifier = $this->doctrineDeviceIdentifierRepository->deviceIdentifierOfIdentifier(new Identifier('SNO', 'SNA78G56'));
        $this->assertTrue($persistedDeviceIdentifier instanceof DeviceIdentifier);
    }        
            
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }            
}
