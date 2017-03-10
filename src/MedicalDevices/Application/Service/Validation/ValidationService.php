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
use MedicalDevices\Application\Service\Validation\Validator;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of ValidationService
 *
 * @author Welpons <welpons@gmail.com>
 */
class ValidationService
{
    private $configurations;
    private $repositories;
    
    public function __construct(ConfigurationInterface $configurations, RepositoryCollection $repositories)
    {
        $this->configurations = $configurations;
        $this->repositories = $repositories;
    }
    
         
    public function validate(ValidatorHandlerInterface $validatorHandler, string $entity, DTOInterface $dto)
    {
        try {
            $validator = $this->createValidator($entity);
            $validator->validate($validatorHandler, $dto);            
        } catch (Exception $ex) {
            $validatorHandler->handleError(ValidationErrors::UNKNOWN_VALIDATION_ERROR, sprintf('Error validating entity: %s. Error: %s', $entity, $ex->getMessage()));
        }
    }   
    
    private function createValidator(string $entity)
    {
        if (!class_exists($entity)) {
            throw new \UnexpectedValueException(sprintf('Validation service. Class not found: %s', $entity));
        }
        
        $reflect = new \ReflectionClass($entity);        
        $entityName = $reflect->getShortName();
        
        $validatorClass = $this->configurations->getParameter("application.validators.{$entityName}");
        
        if (!class_exists($validatorClass)) {
            throw new \UnexpectedValueException(sprintf('Validation service. Validator class not found: %s', $validatorClass));
        }
        
        $validator = new $validatorClass($this->configurations);
        
        if (!is_subclass_of($validator, Validator::class)) {
            throw new \InvalidArgumentException(sprintf('Validator class %s has to extend % class', get_class($validator), Validator::class));
        }
        
        if ($validator->withRepositories()) {
            $validator->addRepositories($this->repositories);
        }
        
        return $validator;
    }     
    
     
}
