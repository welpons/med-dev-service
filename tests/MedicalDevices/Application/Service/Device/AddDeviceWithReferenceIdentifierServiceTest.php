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

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Application\Service\Device\AddDeviceWithReferenceIdentifierService;
use MedicalDevices\Application\Service\ApplicationService;
use MedicalDevices\Application\Service\Device\AddDeviceWithReferenceIdentifierServiceCommandInterface;

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

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->repositories = $this->container->get('repository.collection.provider')->getCollection();
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
}
