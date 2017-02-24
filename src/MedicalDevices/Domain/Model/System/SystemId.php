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

namespace MedicalDevices\Domain\System;

use MedicalDevicesBundle\ExternalServices\UuidGenerator;
use MedicalDevices\Infrastructure\Service\External\UuidGeneratorInterface;

/**
 * Description of SystemId
 *
 * @author Welpons <welpons@gmail.com>
 */
class SystemId
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @param integer $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?: UuidGenerator::uuid();
    }
    /**
     * @return integer
     */
    public function id()
    {
        return $this->id;
    }
    /**
     * @param SystemId $wishId
     *
     * @return bool
     */
    public function equals(SystemId $wishId)
    {
        return $this->id() === $wishId->id();
    }
    /**
     * @return integer
     */
    public function __toString()
    {
        return $this->id();
    }
}