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

namespace Tests\MedicalDevices\Infrastructure\Persistence\Doctrine;

use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\DeviceRepositoryInterface;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceRepository;

/**
 * Description of DeviceRepositoryTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineDeviceRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;
    private $doctrineDeviceRepository;


    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $application = new App(static::$kernel);
        $this->container = static::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
        $this->doctrineDeviceRepository = new DoctrineDeviceRepository($this->em);
        
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
     * @group device_repository
     */    
    public function implementsDomainInterface()
    {
        $this->assertTrue($this->doctrineDeviceRepository instanceof DeviceRepositoryInterface);
    }        
    
    /**
     * @test
     * @group device_repository
     */
    public function findAll()
    {
        $devices = $this->doctrineDeviceRepository->allDevices();
     
        $this->assertTrue(3 == count($devices));
    }   
    
    /**
     * @test
     * @group device_repository
     */
    public function findDeviceOfId()
    {
        $devices = $this->doctrineDeviceRepository->allDevices();     
        $device = current($devices);
       
        $deviceWithId = $this->doctrineDeviceRepository->deviceOfId($device->id());
        
        $this->assertTrue($device->id() instanceof DeviceId);
        $this->assertTrue($deviceWithId instanceof Device);
        $this->assertTrue($device->id()->equals($deviceWithId->id()));
        $this->assertTrue(3 == count($deviceWithId->identifiers()));
    }       
    
    /**
     * @test
     * @group device_repository
     */
    public function findDevicesByModel()
    {
        $devices = $this->doctrineDeviceRepository->allDevicesOfModelId('FORA_D40');
     
        $this->assertTrue(2 == count($devices));
        
        $device = current($devices);
        $this->assertTrue($device instanceof Device);
    }

    /**
     * @test
     * @group device_repository
     */
    public function findDevicesByType()
    {
        $devices = $this->doctrineDeviceRepository->allDevicesOfTypeKey('SCALE');
     
        $this->assertTrue(1 == count($devices));
        
        $device = current($devices);
        $this->assertTrue($device instanceof Device);
    }    
    
    /**
     * @test
     * @group device_repository
     */
    public function findDevicesByCategory()
    {
        $devices = $this->doctrineDeviceRepository->allDevicesOfCategoryId('med');
     
        $this->assertTrue(3 == count($devices));
        
        $device = current($devices);
        $this->assertTrue($device instanceof Device);
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
