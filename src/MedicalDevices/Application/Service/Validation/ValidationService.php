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

namespace MedicalDevices\Application\Service\Validation;

use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Configuration\ConfigurationInterface;
use MedicalDevices\Application\Service\Validation\ValidationErrors;

/**
 * Description of ValidationService
 *
 * @author Welpons <welpons@gmail.com>
 */
class ValidationService
{
    private $configurations;
    private $repositories;
    private $entity;
    
    public function __construct(ConfigurationInterface $configurations, RepositoryCollection $repositories)
    {
        $this->configurations = $configurations;
        $this->repositories = $repositories;
    }
    
         
    public function validate(ValidatorHandlerInterface $validatorHandler, string $entity, DTOInterface $dto)
    {
        try {
            $validator = $this->createValidator($entity, $dto);
            $validator->validate($validatorHandler);            
        } catch (Exception $ex) {
            $validatorHandler->handleError(ValidationErrors::UNKNOWN_VALIDATION_ERROR, sprintf('Error validating entity: %s. Error: %s', $entity, $ex->getMessage()));
        }
    }   
    
    private function createValidator(string $entity, DTOInterface $dto)
    {
        if (!class_exists($entity)) {
            // Exception
        }
        
        $reflect = new ReflectionClass($entity);        
        $entityName = $reflect->getShortName();
        
        $validatorClass = $this->configurations->getParameter("application.validators.{$entityName}");
        
        if (!class_exists($validatorClass)) {
            // Exception
        }
        
        $validator = new $validatorClass($dto);
        
        if ($validator->withRepositories()) {
            $validator->setRepositories($this->repositories);
        }
        
        return $validator;
    }     
    
     
}
