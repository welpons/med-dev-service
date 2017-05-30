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
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\DTO\Device\DeviceCollectionRequestDTO;

/**
 * Description of ListSystemDevicesServices
 *
 * @author Welpons <welpons@gmail.com>
 */
class ListSystemDevicesServices extends DeviceService implements DeviceCollectionServiceCommandInterface
{
    public function execute(ValidatorHandlerInterface $validatorHandler, DeviceCollectionRequestDTO $dto)
    {
        $this->validationService->validate($validatorHandler, 'DeviceCollectionStatus', $dto);
                
        if ($validatorHandler->hasErrors()) {
            throw new ValidationException('Errors validating device collection parameters.');
        }   
        
        return $this->repositories->get('device')->allDevices($dto->deviceStatus());  
    }

}
