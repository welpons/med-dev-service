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

/**
 * Description of DeviceFactory
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceFactory
{
    public static function build(DeviceId $id, string $categoryId, string $modelId, string $modelTypeKey, string $deviceIdentifierType, string $deviceIdentifierValue)
    {
        $deviceIdentifier = DeviceIdentifier::create($deviceIdentifierType, $deviceIdentifierValue, DeviceIdentifier::IS_REFERENCE_ID);
        $device = Device::create($id, $categoryId, $modelId, $modelTypeKey);
        $device->setDeviceIdentifiers([$deviceIdentifier]);
        
        return $device;
    }        
}
