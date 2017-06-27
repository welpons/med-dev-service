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

/**
 * Description of Identifier
 *
 * @author Welpons <welpons@gmail.com>
 */
class Identifier
{
    /**
     * @var string 
     */
    private $type;
    
    /**
     * @var string 
     */
    private $value;
    
    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
    
    public function type(): string
    {
        return $this->type;
    }

    public function value(): string
    {
        return $this->value;
    }    
    
    public function isValidType(array $availableTypes): bool
    {
        return in_array($this->type, $availableTypes);
    }    
    
    public function equals(Identifier $identifier)
    {
        return $this->type === $identifier->type() && $this->value === $identifier->value();
    }        
    
    public function toArray()
    {
        return ['type' => $this->type, 'value' => $this->value];
    }        
}
