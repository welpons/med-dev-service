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

namespace MedicalDevices\Application\Service;

use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of Validator
 *
 * @author Welpons <welpons@gmail.com>
 */
abstract class Validator
{
    protected $repositories;
        
    abstract public function validate(ValidationHandler $validationHandler, DTOInterface $dto);
    
    abstract public function withRepositories() : bool;
    
    public function addRepositories(RepositoryCollection $repositories)
    {
        $this->withRepositories();
        $this->repositories = $repositories;
    }
}
