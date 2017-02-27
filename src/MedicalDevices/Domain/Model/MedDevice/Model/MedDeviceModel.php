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

namespace MedicalDevices\Domain\Model\MedDevice\Model;

use MedicalDevices\Domain\Model\MedDevice\Model\Definition\Definition;
use MedicalDevices\Domain\Model\MedDevice\Model\ModelDetails\ModelDetails;

/**
 * Description of MedDeviceModel
 *
 * @author Welpons <welpons@gmail.com>
 */
class MedDeviceModel
{
    /**
     *
     * @var ModelDetails
     */
    private $modelDetails;
    
    /**
     *
     * @var Definition
     */
    private $definition;
    
    public function __construct(ModelDetails $modelDetails, Definition $definition)
    {
        $this->modelDetails = $modelDetails;
        $this->definition = $definition;
    }

    public function modelDetails(): ModelDetails
    {
        return $this->modelDetails;
    }

    public function definition(): Definition
    {
        return $this->definition;
    }


}
