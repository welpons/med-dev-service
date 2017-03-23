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

namespace MedicalDevices\Application\DTO\Device\Model;

use MedicalDevices\Application\DTO\Device\Model\Type\TypeRequestDTO;
use MedicalDevices\Application\DTO\DTOInterface;

/**
 * Description of ModelDTO
 *
 * @author Welpons <welpons@gmail.com>
 */
class ModelRequestDTO implements DTOInterface
{
    /**
     * @var string 
     */
    private $id;
    
    /**
     * @var MedicalDevices\Application\DTO\Device\Model\Type\TypeRequestDTO 
     */
    protected $type;
    
    public function __construct($id, TypeRequestDTO $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function id()
    {
        return $this->id;
    }        

    public function type()
    {
        return $this->type;
    }    
}
