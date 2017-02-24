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

namespace MedicalDevices\Application\Service\Device;

use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of DeviceDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceDTO implements DTOInterface
{
    use \MedicalDevices\Domain\Model\Device\DeviceTrait;
    
    private $identifier;
    
    public function __construct($identifierValue, $identifierType, $category, $type, $model) 
    {
        $this->identifier = new Identifier($identifierType, $identifierValue);        
        $this->category = $category;
        $this->type = $type;
        $this->model = $model;
    }    
    
    public function identifierValue()
    {
        return $this->identifier->vallue();
    }        
    
    public function identifierType()
    {
        return $this->identifier->type();
    }        
    
    public function identifier()
    {
        return $this->identifier;
    }        
}
