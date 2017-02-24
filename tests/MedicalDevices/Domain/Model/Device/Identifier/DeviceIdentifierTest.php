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

namespace Tests\MedicalDevices\Domain\Model\Device\Identifier;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;

/**
 * Description of IdentifierTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifierTest extends KernelTestCase
{
    /**
     * @test
     * @group model_domain_device_deviceidentifier
     */    
    public function copiedIdentifierShouldRepresentSameValue() 
    {
        $identifier = DeviceIdentifier::create('serial_number', '1234567890A'); 
        
        $copiedIdentifier = DeviceIdentifier::create('serial_number', '1234567890A'); 
        
        $this->assertTrue($identifier->equals($copiedIdentifier));         
        $this->assertTrue($identifier == $copiedIdentifier);
    } 
}
