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
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Device;

/**
 * Description of ViewModelService
 *
 * @author jenkins
 */
class AddDeviceWithReferenceIdentifierService extends ApplicationService implements ApplicationServiceCommand
{
    
    public function execute(DeviceDTO $deviceDTO)
    {        
        $this->checkIfExistingDeviceHasIdentifier($deviceDTO->identifierValue(), $deviceDTO->identifierType());
        
        //Device::validate($this->validatorHandler, $deviceDTO);
        
//        if ($this->validatorHandler->hasErrors()) {
//            return new ValidationErrorsDTO($this->validatorHandler->getErrors());
//        }
//        
//        $device = Device::create($deviceDTO->category(), $deviceDTO->type(), $deviceDTO->model());
        
        $this->repositories['device']->save($device);
        $this->repositories['device_identifier']->save(new DeviceIdentifier($deviceDTO->identifier(), DeviceIdentifier::IS_REFERENCE_ID));              
    }    

    private function checkIfExistingDeviceHasIdentifier($identifierValue, $identifierType)
    {
        $deviceIdentifier = $this->repositories['device_identifier']->deviceIdentifierOfIdentifier($identifierValue, $identifierType);
        
        if ($deviceIdentifier instanceof DeviceIdentifier) {
            throw new IdentifierAlreadyExistsException(sprintf('Already exists a device in the system with %s = %s', $identifierType, $identifierValue));
        }

    }        
}
