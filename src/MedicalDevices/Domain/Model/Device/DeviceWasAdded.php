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

use MedicalDevices\Domain\DomainEventInterface;
use MedicalDevices\Domain\Model\Device\DeviceId;

/**
 * Event
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceWasAdded implements DomainEventInterface
{
    /**
     *
     * @var MedicalDevices\Domain\Model\Device\DeviceId 
     */
    private $deviceId;
    
    /**
     *
     * @var mixed 
     */
    private $content;
    
    /**
     *
     * @var \DateTimeImmutable 
     */
    private $ocurredOn;
    
    public function __construct(DeviceId $deviceId, $content)
    {
        $this->deviceId = $deviceId;
        $this->content = $content;
        $this->occurredOn = new \DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
    
    public function deviceId()
    {
        return $this->deviceId;
    }

    public function content()
    {
        return $this->content;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->ocurredOn;;
    }

}
