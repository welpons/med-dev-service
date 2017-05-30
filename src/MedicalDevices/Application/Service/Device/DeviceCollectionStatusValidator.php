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
use MedicalDevices\Application\DTO\DTOInterface;

/**
 * Description of DeviceStatusValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceCollectionStatusValidator extends Validator
{
    public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto)
    {
        if (false === self::sanatizeItem(self::FILTER_TYPE_STRING, $dto->status())) {
            $validatorHandler->handleError(ValidationErrors::FILTER_INVALID_STRING, sprintf('Invalid device collection status. Must be a valid string'));
        }   
        
        if (!in_array($dto->status(), $dto->allStatuses())) {
            $validatorHandler->handleError(ValidationErrors::DEVICE_COLLECTION_STATUS_NOT_FOUND, sprintf('Not found device collection status: %s. Must be one of these: "%s"', $dto->status(), implode(',', $dto->allStatuses())));
        }        
    }

    public function withRepositories(): bool
    {
        return false;
    }

}
