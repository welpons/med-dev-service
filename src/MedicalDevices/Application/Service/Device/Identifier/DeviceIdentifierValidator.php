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

namespace MedicalDevices\Application\Service\Device\Identifier;

use MedicalDevices\Application\Service\Validation\Validator;
use MedicalDevices\Application\Service\Validation\ValidationErrors;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\DTO\DTOInterface;

/**
 * Description of DeviceIdentifierValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifierValidator extends Validator
{

    public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto)
    {
        $value = $dto->value();
        if (empty($value)) {
            $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_IDENTIFIER_VALUE, sprintf('Undefined device identifier value: %s', $value));
        }

        if (false === self::sanatizeItem(self::FILTER_TYPE_STRING, $value)) {
            $validatorHandler->handleError(ValidationErrors::FILTER_INVALID_STRING, sprintf('Invalid device identifier value. Must be a valid string'));
        }

        $type = $dto->type();
        if (empty($type)) {
            $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_IDENTIFIER_TYPE, sprintf('Undefined device identifier type: %s', $type));
        }

        if (false === self::sanatizeItem(self::FILTER_TYPE_STRING, $type)) {
            $validatorHandler->handleError(ValidationErrors::FILTER_INVALID_STRING, sprintf('Invalid device identifier type. Must be a valid string'));
        }

        $types = array_values($this->configurations->getParameter('application.identifier_types'));
        if (!in_array($type, $types)) {
            $validatorHandler->handleError(ValidationErrors::INVALID_DEVICE_IDENTIFIER_TYPE, sprintf('Invalid device identifier type. Must be one of the following types: %s', implode(',', $types)));
        }
    }

    public function withRepositories(): bool
    {
        return false;
    }

}
