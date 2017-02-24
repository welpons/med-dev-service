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

/**
 *
 * @author Welpons <welpons@gmail.com>
 */
trait DeviceTrait
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
    private $typeKey;
    
    /**
     *
     * @var string 
     */
    private $modelId;
        
    /**
     *
     * @var ArrayCollection 
     */
    protected $identifiers;
    
    
    public function categoryId() : string
    {
        return $this->categoryId;
    }        
    
    public function modelId() : string
    {
        return $this->modelId;
    }  
    
    public function typeKey() : string
    {
        return $this->typeKey;
    }      
    
   
    
    public function identifiers() : array
    {
        return $this->identifiers;
    }       
}
