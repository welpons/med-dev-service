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

use MedicalDevices\Domain\Model\Device\Device;

/**
 * Entity: Identifier of a medical device. A medical device can have more than one.
 * Example: key: "serial_number", value: "5E7Z550HZ"
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifier
{
    const IS_REFERENCE_ID = true;
    const IS_NOT_REFERENCE_ID = false;
    
    /**
     * @var integer 
     */
    private $id;
    
    /**
     * @var Identifier
     */
    private $identifier;
    
    /**
     * @var boolean 
     */
    private $isReferenceIdentifier = false;
    
    /**
     * This attribute is not part of the domain
     * 
     * @var MedicalDevices\Domain\Model\Device\Device 
     */
    private $device;
    
    public function __construct(Identifier $identifier, $isReferenceIdentifier = self::IS_NOT_REFERENCE_ID, Device $device = null)
    {
        $this->device = $device;
        $this->setIdentifier($identifier, $isReferenceIdentifier);
    }
    
    private function setIdentifier($identifier, $isReferenceIdentifier)
    {
        $this->identifier = $identifier;
        $this->isReferenceIdentifier = $isReferenceIdentifier;
    }        
    
    public function device()
    {
        return $this->device;
    }        
            
    public function identifier(): Identifier
    {
        return $this->identifier;
    }    

    public function isReferenceIdentifier(): bool
    {
        return $this->isReferenceIdentifier;
    }        
        
    public function setIsReferenceIdentifier(bool $isReferenceIdentifier)
    {
        $this->isReferenceIdentifier = $isReferenceIdentifier;
    }
    
    public function equals(DeviceIdentifier $medDevIdentifier): bool
    {
        return $this->identifier->equals($medDevIdentifier->identifier) && $this->isReferenceIdentifier === $medDevIdentifier->isReferenceIdentifier();
    }        
    
    public static function create($identifierType, $identifierValue, $isReferenceIdentifier = self::IS_NOT_REFERENCE_ID)
    {
        return new self(new Identifier($identifierType, $identifierValue), $isReferenceIdentifier);
    }        
    
    public function toArray()
    {
        return ['Identifier' => $this->identifier->toArray()];
    }        
}
