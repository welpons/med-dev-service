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

namespace MedicalDevices\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform; 
use MedicalDevices\Domain\Model\Device\DeviceId;
 
/**
 * Description of DeviceId
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineDeviceId extends GuidType
{
    public function getName() 
    { 
        return 'device_id'; 
    } 
    
    public function convertToDatabaseValue($value, AbstractPlatform $platform) 
    {        
        return $value->id();         
    } 
    
    public function convertToPHPValue($value, AbstractPlatform $platform): DeviceId
    { 
        return DeviceId::create($value);
    } 
}
