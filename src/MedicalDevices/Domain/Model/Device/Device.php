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

namespace MedicalDevices\Domain\Model\Device;

use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of MedDevice
 *
 * @author Welpons <welpons@gmail.com>
 */
class Device
{
    
    /**
     * @var DeviceId 
     */
    private $id;    
    
    /**
     *
     * @var string 
     */
    private $categoryId;
        
    /**
     *
     * @var Model 
     */
    private $model;
        
    /**
     *
     * @var array
     */
    protected $identifiers;
        
    public function __construct(DeviceId $id, string $categoryId, Model $model) 
    {
        $this->identifiers = array();
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->model = $model;
    }    
    
    public static function create(DeviceId $id, string $categoryId, string $modelId, string $modelTypeKey)
    {
        if (null === $id) {
            $id = DeviceId::create();
        }
        
        return new self($id, $categoryId, new Model($modelId, new Type($modelTypeKey)));
    }        
                
    public function setIdentifiers(array $identifiers)
    {
        $this->identifiers = $identifiers;
        
        return $this;
    }    

    public function id(): DeviceId
    {
        return $this->id;
    }        
        
    public function categoryId() : string
    {
        return $this->categoryId;
    }        
    
    public function model() : Model
    {
        return $this->model;
    }     
    
    public function identifiers() : array
    {
        return $this->identifiers;
    }       
    
    public function __toString()
    {
        return $this->id->id();
    }    
}
