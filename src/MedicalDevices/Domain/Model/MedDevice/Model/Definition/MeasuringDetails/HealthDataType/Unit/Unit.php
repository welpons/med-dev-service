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

namespace MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit;

/**
 * Description of Unit
 *
 * @author Welpons <welpons@gmail.com>
 */
class Unit
{

    /**
     * @var string 
     */
    private $name;

    /**
     * @var string 
     */
    private $symbol;

    /**
     * @var boolean
     */
    private $default = false;

    public function name(): string
    {
        return $this->name;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function defaultUnit(): bool
    {
        return $this->default;
    }

    public function equals(Unit $unit)
    {
        return $unit->name() === $this->name();
    }

}
