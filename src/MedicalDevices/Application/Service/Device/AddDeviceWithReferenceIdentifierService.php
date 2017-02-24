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
use MedicalDevices\Application\Service\ApplicationServiceCommand;
use MedicalDevices\Application\Service\Validation\ValidationException;
use MedicalDevices\Application\Service\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\DTOInterface;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;

/**
 * Description of ViewModelService
 *
 * @author jenkins
 */
class AddDeviceWithReferenceIdentifierService extends ApplicationService implements ApplicationServiceCommand
{
    
    public function execute(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto = null)
    {                
        $this->validationService->validate($validatorHandler, "MedicalDevices\Domain\Model\Device", $dto);
        
        if ($validatorHandler->hasErrors()) {
            throw new ValidationException('Errors validating device parameters');
        }
        
        $deviceIdentifier = DeviceIdentifier::create($dto->deviceIdentifier()->type(), $dto->deviceIdentifier()->value(), DeviceIdentifier::IS_REFERENCE_ID);
        $device = Device::create(DeviceId::create(), $dto->categoryId(), $dto->modelId(), $dto->modelTypeKey())
                ->setIdentifiers($deviceIdentifier);
        
        $this->repositories['device']->save($device);
        $this->repositories['device_identifier']->save($deviceIdentifier);              
    }    

     
}
