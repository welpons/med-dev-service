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

namespace Tests\MedicalDevices\Domain\Model\Device;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\Collections\ArrayCollection;

use MedicalDevices\Application\DTO\Device\DeviceRequestDTO;
use MedicalDevices\Application\DTO\Device\Identifier\DeviceIdentifierRequestDTO;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

class DeviceTest extends KernelTestCase
{

    public function setUp()
    {
        self::bootKernel();

        $this->container = static::$kernel->getContainer();
        $this->init = $this->container->get('init');
    }

    /**
     * @test
     * @group model_domain_device
     */
    public function deviceCreation()
    {
        $id = DeviceId::create();
        $deviceFactory = Device::create($id, 'med', 'FORA_D40', 'GLUCO', $this->init->getParameter('application.ref_identifier_type'));

        $deviceWithConstructor = new Device($id, 'med', new Model('FORA_D40', new Type('GLUCO')), $this->init->getParameter('application.ref_identifier_type'));

        $this->assertTrue($deviceFactory->categoryId() === $deviceWithConstructor->categoryId() && $deviceFactory->model()->id() === $deviceWithConstructor->model()->id() && $deviceFactory->model()->type()->key() === $deviceWithConstructor->model()->type()->key());
    }

    /**
     * @test
     * @group model_domain_device
     */
    public function deviceCreationWithConstructor()
    {
        $id = DeviceId::create();
        $createdAt = new \DateTimeImmutable();
        $deviceWithConstructor = new Device($id, 'med', new Model('FORA_D40', new Type('GLUCO')), $this->init->getParameter('application.ref_identifier_type'), $createdAt);
        $this->assertEquals($deviceWithConstructor->createdAt(), $createdAt);
    }        
    
    /**
     * @test
     * @group model_domain_device
     */
    public function setDeviceIdentifiersOneReferenceIdentifier()
    {
        $identifiers = new ArrayCollection;

        $identifiers->add(new DeviceIdentifierRequestDTO('SNO', 'SNAF67H567', true));  
        $identifiers->add(new DeviceIdentifierRequestDTO('MAC', '00:15:E9:2B:99:3C', false));  
        $deviceDTO = new DeviceRequestDTO('med', 'FORA_D40', 'GLUCO', $identifiers);
        
        $id = DeviceId::create();
        $deviceFactory = Device::create($id, $deviceDTO->categoryId(), $deviceDTO->model()->id(), $deviceDTO->model()->type()->Key(), $this->init->getParameter('application.ref_identifier_type'));        
        $deviceFactory->setDeviceIdentifiers($deviceDTO->deviceIdentifiers());
        $deviceIdentifiers = $deviceFactory->deviceIdentifiers();
        $this->assertTrue(current($deviceIdentifiers) instanceof DeviceIdentifier);
        
        $countDeviceReferenceIdentifier = 0;
        
        foreach($deviceIdentifiers as $deviceIdentifier) {
            if ($deviceIdentifier->isReferenceIdentifier()) {
                $countDeviceReferenceIdentifier++;
                $referenceIdentifier = $deviceIdentifier;
            }
        }
  
        $this->assertEquals(1, $countDeviceReferenceIdentifier);
        $this->assertEquals('SNO', $referenceIdentifier->identifier()->type());
    }        
    
    /**
     * @test
     * @group model_domain_device
     * @expectedException MedicalDevices\Domain\Model\Device\MultipleReferenceDeviceIdentifiersException
     */
    public function setDeviceIdentifiersMultipleReferenceIdentifier()
    {
        $identifiers = new ArrayCollection;

        $identifiers->add(new DeviceIdentifierRequestDTO('SNO', 'SNAF67H567', true));  
        $identifiers->add(new DeviceIdentifierRequestDTO('MAC', '00:15:E9:2B:99:3C', true));  
        $deviceDTO = new DeviceRequestDTO('med', 'FORA_D40', 'GLUCO', $identifiers);
        
        $id = DeviceId::create();
        $deviceFactory = Device::create($id, $deviceDTO->categoryId(), $deviceDTO->model()->id(), $deviceDTO->model()->type()->Key(), $this->init->getParameter('application.ref_identifier_type'));        
        $deviceFactory->setDeviceIdentifiers($deviceDTO->deviceIdentifiers());

    }        
    
    /**
     * @test
     * @group model_domain_device
     */
    public function setDeviceIdentifiersNoReferenceIdentifier()
    {
        $identifiers = new ArrayCollection;

        $identifiers->add(new DeviceIdentifierRequestDTO('SNO', 'SNAF67H567', false));  
        $identifiers->add(new DeviceIdentifierRequestDTO('MAC', '00:15:E9:2B:99:3C', false));  
        $deviceDTO = new DeviceRequestDTO('med', 'FORA_D40', 'GLUCO', $identifiers);
        
        $id = DeviceId::create();
        $deviceFactory = Device::create($id, $deviceDTO->categoryId(), $deviceDTO->model()->id(), $deviceDTO->model()->type()->Key(), $this->init->getParameter('application.ref_identifier_type'));        
        $deviceFactory->setDeviceIdentifiers($deviceDTO->deviceIdentifiers());
        $deviceIdentifiers = $deviceFactory->deviceIdentifiers();
        $this->assertTrue(current($deviceIdentifiers) instanceof DeviceIdentifier);
        
        $countDeviceReferenceIdentifier = 0;
        
        foreach($deviceIdentifiers as $deviceIdentifier) {
            if ($deviceIdentifier->isReferenceIdentifier()) {
                $countDeviceReferenceIdentifier++;
                $referenceIdentifier = $deviceIdentifier;
            }
        }
  
        $this->assertEquals(1, $countDeviceReferenceIdentifier);
        $this->assertEquals('SNO', $referenceIdentifier->identifier()->type());
    }       
    
}
