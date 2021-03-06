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

namespace Tests\MedicalDevices\Infrastructure\Persistence\DoctrineMongoDB;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of DoctrineMongoDBDeviceRepositoryTest
 *
 * @author jenkins
 */
class DoctrineMongoDBDeviceRepositoryTest extends KernelTestCase 
{
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->init = $this->container->get('init');        
        
        $fixture = new LoadDeviceData($this->init->getParameter('application.ref_identifier_type'));
        $fixture->load();    
    } 
    
    /**
     * @test
     * @group mongodb_device_repository
     */
    public function test() 
    {
    
        $this->assertTrue(true);
    }
}
