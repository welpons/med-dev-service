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

namespace MedicalDevices\Domain\Model\Device\Identifier;

use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Infrastructure\Persistence\RepositoryInterface;

/**
 *
 * @author Welpons <welpons@gmail.com>
 */
interface DeviceIdentifierRepositoryInterface extends RepositoryInterface
{
    
    public function save(DeviceIdentifier $deviceIdentifier);
    
    public function remove(DeviceIdentifier $deviceIdentifier);
    
    public function allDeviceIdentifiers();    
    
    public function deviceIdentifierOfIdentifier(Identifier $identifier);
    
    public function deviceIdentifiersOfDevice(DeviceId $deviceId);
    
    public function referenceDeviceIdentifierOfDevice(DeviceId $deviceId);
}
