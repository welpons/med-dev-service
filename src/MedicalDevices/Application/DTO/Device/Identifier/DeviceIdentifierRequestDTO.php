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

namespace MedicalDevices\Application\DTO\Device\Identifier;

use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Application\DTO\DTOInterface;

/**
 * Description of DeviceIdentifierDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifierRequestDTO implements DTOInterface
{
    /**
     * @var string 
     */
    private $type = null;
    
    /**
     * @var string 
     */
    private $value = null;
    
    /**
     * @var bool 
     */
    private $isReferenceIdentifier = false;
    
    /**
     * 
     * @param string $type
     * @param string $value
     * @param type   $isReferenceIdentifier
     */
    public function __construct(string $type, string $value, $isReferenceIdentifier = DeviceIdentifier::IS_NOT_REFERENCE_ID)
    {
        $this->type = $type;
        $this->value = $value;
        $this->isReferenceIdentifier = $isReferenceIdentifier;
    }

    public function type()
    {
        return $this->type;
    }        
    
    public function value()
    {
        return $this->value;
    }        
    
    public function isReferenceIdentifier()
    {
        return $this->isReferenceIdentifier;
    }     
    
    public function setIsReferenceIdentifier(bool $isReferenceIdentifier)
    {
        $this->isReferenceIdentifier = $isReferenceIdentifier;
    }            
}
