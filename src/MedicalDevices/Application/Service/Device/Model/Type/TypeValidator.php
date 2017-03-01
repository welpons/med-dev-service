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

namespace MedicalDevices\Application\Service\Device\Model\Type;

use MedicalDevices\Application\Service\Validation\Validator;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\Validation\ValidationErrors;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of TypeValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class TypeValidator extends Validator
{

    //put your code here
    public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto)
    {
        // Device type Key validations
        $typeKey = $dto->key();
        if (empty($typeKey)) {
            $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_TYPE_KEY, sprintf('Undefined device model type key: %s', $typeKey));
        }

        if (false === self::sanatizeItem(self::FILTER_TYPE_STRING, $typeKey)) {
            $validatorHandler->handleError(ValidationErrors::FILTER_INVALID_STRING, sprintf('Invalid device model type key. Must be a valid string'));
        }

        if ($this->withRepositories()) {
            if (null === $this->repositories) {
                $validatorHandler->handleError(ValidationErrors::UNDEFINED_REPOSITORY, 'Device Moded Type validation. Is required to set a repository to validate device model type.');
                return;
            }

            if (null === $this->repositories->get('device_types')->typeOfKey($typeKey)) {
                $validatorHandler->handleError(ValidationErrors::NOT_FOUND_DEVICE_MODEL_TYPE_KEY, sprintf('Not found device type key: %s', $typeKey));
            }
        }        
        

    }

    public function withRepositories(): bool
    {
        return true;
    }

}
