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

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;

/**
 * Description of LoadDeviceIdentifierData
 *
 * @author Welpons <welpons@gmail.com>
 */
class LoadDeviceIdentifierData implements FixtureInterface
{
    private $refIdentifierType;
    
    public function __construct($refIdentifierType)
    {
        $this->refIdentifierType = $refIdentifierType;
    }        
    
    
    public function load(ObjectManager $manager)
    {
        $deviceId = DeviceId::create();
        $device = new Device(DeviceId::create(), 'med', new Model('FORA_D40', new Type('GLUCO', 'glucometer')), $this->refIdentifierType, new \DateTimeImmutable());

        $manager->persist($device);        
        
        $identifierSN = new Identifier('SNO', 'SN123456');
        $identifierMAC = new Identifier('MAC', '00:0a:95:9d:68:16');
        $identifierUID = new Identifier('UID', 'b776da23-a9be-4b3a-9c7e-d359713fca58');
        $deviceIdentifierSN = new DeviceIdentifier($identifierSN, DeviceIdentifier::IS_NOT_REFERENCE_ID, $device);
        $deviceIdentifierMAC = new DeviceIdentifier($identifierMAC, DeviceIdentifier::IS_NOT_REFERENCE_ID, $device);
        $deviceIdentifierUID = new DeviceIdentifier($identifierUID, DeviceIdentifier::IS_REFERENCE_ID, $device);
     
        $manager->persist($deviceIdentifierSN);         
        $manager->persist($deviceIdentifierMAC); 
        $manager->persist($deviceIdentifierUID); 
        
        $manager->flush();
    }
}
