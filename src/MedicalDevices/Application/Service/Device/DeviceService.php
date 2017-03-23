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

use MedicalDevices\Application\Service\ApplicationService;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\Validation\ValidationErrors;
use MedicalDevices\Application\DTO\Device\Identifier\DeviceIdentifierRequestDTO;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;

/**
 * Description of DeviceService
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceService extends ApplicationService
{
    protected function checkWhetherDeviceIdentifierAlreadyExists(ValidatorHandlerInterface $validatorHandler, array $deviceIdentifiers)
    {
        foreach($deviceIdentifiers as $identifier) {
            if ($this->repositories->get('device_identifier')->deviceIdentifierOfIdentifier(new Identifier($identifier->type(), $identifier->value())) instanceof DeviceIdentifier) {
                $validatorHandler->handleError(ValidationErrors::DEVICE_IDENTIFIER_ALREADY_EXISTS, sprintf('This Device identifier %s = %s is assigned to another device', $identifier->type(), $identifier->value()));
            }
        }
    }   
    
    protected function checkWhetherDeviceIdentifierExists(ValidatorHandlerInterface $validatorHandler, DeviceIdentifierRequestDTO $dto)
    {
        $deviceIdentifier = $this->repositories->get('device_identifier')->deviceIdentifierOfIdentifier(new Identifier($dto->type(), $dto->value()));
        if (null === $deviceIdentifier) {
            $validatorHandler->handleError(ValidationErrors::DEVICE_IDENTIFIER_NOT_FOUND, sprintf('This Device identifier %s = %s is not found in the system', $dto->type(), $dto->value()));
        }   
        
        return $deviceIdentifier;
    }     
}
