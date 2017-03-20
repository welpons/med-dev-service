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

use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierServiceCommandInterface;
use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierRequestDTO;

/**
 * Description of FindDeviceByIdentifierService
 *
 * @author Welpons <welpons@gmail.com>
 */
class FindDeviceByIdentifierService extends ApplicationService implements DeviceIdentifierServiceCommandInterface
{
    
    public function execute(ValidatorHandlerInterface $validatorHandler, DeviceIdentifierRequestDTO $dto)
    {
        $deviceIdentifier = $this->checkWhetherDeviceIdentifierExists($validatorHandler, $dto);
          
        if (!$deviceIdentifier) {
            throw new NotFoundDeviceIdentifierException(implode(',', array_values($validatorHandler->getErrors())));
        }          
        
        $device = $this->repositories->get('device')->deviceOfId(DeviceId::create($deviceIdentifier->deviceId()));

    }   
}    
