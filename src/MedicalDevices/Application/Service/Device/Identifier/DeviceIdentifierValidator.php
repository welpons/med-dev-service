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
use MedicalDevices\Application\Service\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of DeviceIdentifierValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifierValidator extends Validator
{
    public function validate(ValidatorHandlerInterface $validationHandler, DTOInterface $dto)
    {
        if ($this->withRepositories()) {
           if (null === $this->repositories['device_identifier']->deviceIdentifierOfIdentifier($dto->deviceIdentifier()->value(), $dto->deviceIdentifier()->type())) {
               $validationHandler->handleError(ValidationErrors::DEVICE_IDENTIFIER_ALREADY_EXISTS, sprintf('Already exists a device in the system with %s = %s', $dto->deviceIdentifier()->type(), $dto->deviceIdentifier()->value()));
           }
        }
    }

    public function withRepositories(): bool
    {
        return true;
    }

}
