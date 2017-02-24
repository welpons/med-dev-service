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

namespace MedicalDevices\Domain\Model\Device;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Application\Service\Device\DeviceDTO;

/**
 * Description of DeviceTraitTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceTraitTest extends KernelTestCase
{
    private $device;
    private $deviceDTO;
    
    public function setUp()
    {
        $this->device = new Device(DeviceId::create(), 'med', 'GLUCO', 'FORA_D40');
        $this->deviceDTO = new DeviceDTO('SN1234567', 'SNO', 'med', 'GLUCO', 'FORA_D40');
    }        
    
    /**
     * @test
     * @group model_domain_device_devicetrait
     */
    public function getCategory()
    {
        $this->assertSame($this->device->categoryId(), $this->deviceDTO->categoryId());
    }        
    
    /**
     * @test
     * @group model_domain_device_devicetrait
     */
    public function getType()
    {
        $this->assertSame($this->device->typeKey(), $this->deviceDTO->typeKey());
    }      
    
    /**
     * @test
     * @group model_domain_device_devicetrait
     */
    public function getModel()
    {
        $this->assertSame($this->device->modelId(), $this->deviceDTO->modelId());
    }        
}
