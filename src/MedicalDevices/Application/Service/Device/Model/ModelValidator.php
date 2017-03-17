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

namespace MedicalDevices\Application\Service\Device\Model;

use MedicalDevices\Application\Service\Validation\Validator;
use MedicalDevices\Application\Service\Validation\ValidationErrors;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of ModelValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class ModelValidator extends Validator
{

    //put your code here
    public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto)
    {
        // Device model Id validations
        $modelId = $dto->id();
        if (empty($modelId)) {
            $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_MODEL_ID, sprintf('Undefined device model Id: %s', $modelId));
        }

        if (false === self::sanatizeItem(self::FILTER_TYPE_STRING, $modelId)) {
            $validatorHandler->handleError(ValidationErrors::FILTER_INVALID_STRING, sprintf('Invalid device model Id. Must be a valid string'));
        }

        if ($this->withRepositories()) {
            if (null === $this->repositories) {
                $validatorHandler->handleError(ValidationErrors::UNDEFINED_REPOSITORY, 'Device model Id validation. Is required to set a repository to validate device model Id.');
                return;
            }

            if (null === $this->repositories->get('device_model')->modelOfId($modelId)) {
                $validatorHandler->handleError(ValidationErrors::NOT_FOUND_DEVICE_MODEL_ID, sprintf('Not found device model Id: %s', $modelId));
            }
        }
    }

    public function withRepositories(): bool
    {
        return true;
    }

}
