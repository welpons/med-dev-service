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

use MedicalDevices\Application\Service\Device\DeviceService;
use MedicalDevices\Application\Service\Validation\ValidationException;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\DTO\Device\DeviceRequestDTO;
use MedicalDevices\Application\DTO\Device\DeviceResponseDTO;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\DeviceFactory;

/**
 * Adds a new device in the system with its device identifiers
 *
 * @author jenkins
 */
class AddDeviceWithReferenceIdentifierService extends DeviceService implements DeviceServiceCommandInterface
{
    
    public function execute(ValidatorHandlerInterface $validatorHandler, DeviceRequestDTO $dto)
    {                
        $this->validationService->validate($validatorHandler, Device::class, $dto);
                
        if ($validatorHandler->hasErrors()) {
            throw new ValidationException('Errors validating device parameters');
        }
        
        $this->checkWhetherDeviceIdentifierAlreadyExists($validatorHandler, $dto->deviceIdentifiers());

        if ($validatorHandler->hasErrors()) {
            throw new DeviceIdentifierAlreadyExistsException('One or more device identifiers already identify another device. Errors: %s', implode(',', array_values($validatorHandler->getErrors())));
        }        
                
        $device = DeviceFactory::buildWithIdentifiers(DeviceId::create(), $dto->categoryId(), $dto->model()->id(), $dto->model()->type()->key(), $dto->deviceIdentifiers(), $this->configurations->getParameter('application.ref_identifier_type'));

        $this->repositories->get('device')->save($device);    

        return new DeviceResponseDTO($device);
    }    
    
}
