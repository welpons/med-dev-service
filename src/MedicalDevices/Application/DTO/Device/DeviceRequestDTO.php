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

use MedicalDevices\Application\DTO\DTOInterface;
use MedicalDevices\Application\DTO\Device\Model\ModelRequestDTO;
use MedicalDevices\Application\DTO\Device\Model\Type\TypeRequestDTO;

/**
 * Description of DeviceIdentifierDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceRequestDTO implements DTOInterface
{
    const OBJECT = 0;
    const TO_ARRAY = 1;
    
    public function __construct(string $categoryId, string $modelId, string $modelTypeKey, $deviceIdentifiers) 
    {
        $this->categoryId = $categoryId;
        $this->model = new ModelRequestDTO($modelId, new TypeRequestDTO($modelTypeKey));
        $this->deviceIdentifiers = $deviceIdentifiers;
    }  
    
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
     * @var ArrayCollection<MedicalDevices\Application\DTO\Device\Identifier\DeviceIdentifierRequestDTO> 
     */
    private $deviceIdentifiers;    
    
    /**
     * 
     * @param int $typeToRetrieve
     * @return array|Doctrine\Common\Collections\ArrayCollection
     */
    public function deviceIdentifiers($typeToRetrieve = self::TO_ARRAY)
    {
        if ($typeToRetrieve == self::TO_ARRAY) {
            return $this->deviceIdentifiers->toArray();
        }
        
        return $this->deviceIdentifiers;
    }
  
    public function categoryId()
    {
        return $this->categoryId;
    }

    public function model(): ModelRequestDTO
    {
        return $this->model;
    }

}
