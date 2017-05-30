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

namespace MedicalDevices\Application\DTO\Device;

use MedicalDevices\Domain\Model\Device\Device;

/**
 * Description of DeviceListRequestDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceCollectionRequestDTO
{
    const ONLY_ACTICE = 'only_active';
    const ONLY_INACTIVE = 'only_inactive';
    const ALL = 'all';
    
    const STATUSES = array(self::ONLY_ACTICE => Device::STATUS_ACTIVE, self::ONLY_INACTIVE => Device::STATUS_INACTIVE, self::ALL => null);
    
    private $status = self::ALL;
    
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function status()
    {        
        return $this->status;
    }
    
    public function allStatuses()
    {
        return array_keys(self::STATUSES);
    }
    
    public function deviceStatus()
    {
        return self::STATUSES[$this->status];
    }        
}
