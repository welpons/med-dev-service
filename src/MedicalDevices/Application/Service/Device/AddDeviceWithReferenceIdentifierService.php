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
use MedicalDevices\Application\Service\Validation\ValidationException;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\Validation\ValidationErrors;
use MedicalDevices\Application\Service\Device\DeviceRequestDTO;
use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierRequestDTO;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\DeviceFactory;

/**
 * Description of ViewModelService
 *
 * @author jenkins
 */
class AddDeviceWithReferenceIdentifierService extends ApplicationService implements AddDeviceWithReferenceIdentifierServiceCommandInterface
{
    
    public function execute(ValidatorHandlerInterface $validatorHandler, DeviceRequestDTO $dto)
    {                
        $this->validationService->validate($validatorHandler, Device::class, $dto);
        
        $this->checkWhetherDeviceIdentifierAlreadyExists($validatorHandler, $dto->deviceIdentifiers());
        
        if ($validatorHandler->hasErrors()) {
            throw new ValidationException('Errors validating device parameters');
        }
        
        $device = DeviceFactory::buildWithIdentifiers(DeviceId::create(), $dto->categoryId(), $dto->model()->id(), $dto->model()->type()->key(), $dto->deviceIdentifiers(), $this->configurations->getParameter('application.ref_identifier_type'));

        $this->repositories->get('device')->save($device);    

        return new DeviceResponseDTO($device);
    }    

    private function checkWhetherDeviceIdentifierAlreadyExists(ValidatorHandlerInterface $validatorHandler, array $deviceIdentifiers)
    {
        foreach($deviceIdentifiers as $identifier) {
            if ($this->repositories->get('device_identifier')->deviceIdentifierOfIdentifier(new Identifier($identifier->type(), $identifier->value())) instanceof DeviceIdentifier) {
                $validatorHandler->handleError(ValidationErrors::DEVICE_IDENTIFIER_ALREADY_EXISTS, sprintf('This Device identifier %s = %s is assigned to another device', $identifier->type(), $identifier->value()));
            }
        }
    }        
}
