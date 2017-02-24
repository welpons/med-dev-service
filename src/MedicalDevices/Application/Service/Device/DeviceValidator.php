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

use MedicalDevices\Application\Service\Validation\Validator;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\Validation\ValidationErrors;
use MedicalDevices\Application\Service\DTOInterface;
use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierValidator;
/**
 * Description of DeviceValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceValidator extends Validator
{
    

    public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto)
    {
        if ($this->withRepositories()) {
            if (null === $this->repositories['device_categories']->categoryOfId($dto->categoryId())) {
                $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_CATEGORY_ID, sprintf('Undefined device category Id: %s', $dto->categoryId()));
            }
            
            if (null === $this->repositories['device_types']->typeOfKey($dto->model()->type()->key())) {
                $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_MODEL_TYPE_KEY, sprintf('Undefined device model type key: %s', $dto->model()->type()->key()));
            }
            
            if (null === $this->repositories['device_models']->modelOfId($dto->model()->Id())) {
                $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_MODEL_ID, sprintf('Undefined device model Id: %s', $dto->model()->id()));
            }
            
            $deviceIdentifierValidator = new DeviceIdentifierValidator();
            $deviceIdentifierValidator->addRepositories($this->repositories);
            $deviceIdentifierValidator->validate($validationHandler, $dto->deviceIdentifier());
        }
    }

    public function withRepositories(): bool
    {
        return true;
    }
    

}
