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

use MedicalDevices\Application\DTO\Device\Identifier\DeviceIdentifierRequestDTO;
use MedicalDevices\Application\DTO\Device\Model\ModelRequestDTO;
use MedicalDevices\Application\DTO\Device\Model\Type\TypeRequestDTO;
use MedicalDevices\Application\DTO\DTOInterface;


/**
 * Description of DeviceDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceRequestDTO implements DTOInterface
{

    /**
     * @var string 
     */
    private $categoryId = null;
        
    /**
     *
     * @var MedicalDevices\Application\DTO\Device\Model\ModelRequestDTO 
     */
    private $model = null;
            
    /**
     *
     * @var array<MedicalDevices\Application\DTO\Device\Identifier\DeviceIdentifierRequestDTO> 
     */
    private $deviceIdentifiers = null;
    
    /**
     * 
     * @param string $categoryId
     * @param string $modelId
     * @param string $modelTypeKey
     * @param array $deviceIdentifiers
     */
    public function __construct(string $categoryId, string $modelId, string $modelTypeKey, array $deviceIdentifiers) 
    {
        $this->categoryId = $categoryId;
        $this->model = new ModelRequestDTO($modelId, new TypeRequestDTO($modelTypeKey));
        
        foreach($deviceIdentifiers as $deviceIdentifier) {           
            $this->deviceIdentifiers[] = new DeviceIdentifierRequestDTO($deviceIdentifier['type'], $deviceIdentifier['value'], (in_array('is_reference_identifier', $deviceIdentifier) ? true : false));
        }
    }    
    
    public function deviceIdentifiers()
    {
        return $this->deviceIdentifiers;
    }     
    
    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function model(): ModelRequestDTO
    {
        return $this->model;
    }    

}
