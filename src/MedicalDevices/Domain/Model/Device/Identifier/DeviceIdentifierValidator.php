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

use MedicalDevices\Application\Service\Validator;

/**
 * Description of DeviceIdentifierValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifierValidator extends Validator
{
    private $deviceIdentifier;
    private $identifierTypes;
    
    public function __construct(array $identifierTypes, DeviceIdentifier $deviceIdentifier,  ValidationHandler $validationHandler)
    {
        parent::__construct($validationHandler); 
        $this->identifierTypes = $identifierTypes;
        $this->deviceIdentifier = $deviceIdentifier;
    }
    
    public function validate()
    {
        if ($this->deviceIdentifier->identifier()->isValidType(array_values($this->identifierTypes))) {
             $this->handleError(sprintf('Invalid identifier type: %s. Must be one of these: %s', $this->deviceIdentifier->type(), implode(',', array_values($this->identifierTypes)))); 
        }
    }        
}
