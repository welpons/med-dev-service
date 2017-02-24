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

use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierDTO;
use MedicalDevices\Application\Service\DTOInterface;


/**
 * Description of DeviceDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceDTO implements DTOInterface
{

    /**
     *
     * @var string 
     */
    private $categoryId;
        
    /**
     *
     * @var string 
     */
    private $modelId;
        
    /**
     
     * @var string 
     */
    private $modelTypeKey;
    
    /**
     *
     * @var DeviceIdentifier 
     */
    private $identifier;
    
    public function __construct(string $categoryId, string $modelId, string $modelTypeKey, string $identifierValue, string $identifierType) 
    {
        $this->identifier = new DeviceIdentifierDTO($identifierType, $identifierValue, true);        
        $this->categoryId = $categoryId;
        $this->modelId = $modelId;
        $this->modelTypeKey = $modelTypeKey;
    }    
    
    public function deviceIdentifier(): DeviceIdentifierDTO
    {
        return $this->identifier;
    }     
    
    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function modelId(): string
    {
        return $this->modelId;
    }

    public function modelTypeKey(): string
    {
        return $this->modelTypeKey;
    }

    
}
