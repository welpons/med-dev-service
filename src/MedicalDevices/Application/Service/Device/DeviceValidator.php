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
use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierValidator;
use MedicalDevices\Application\Service\Device\Model\ModelValidator;

/**
 * Description of DeviceValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceValidator extends Validator
{

    public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto)
    {
        // Device Category Id validations
        $categoryId = $dto->categoryId();
        if (empty($categoryId)) {
            $validatorHandler->handleError(ValidationErrors::UNDEFINED_DEVICE_CATEGORY_ID, sprintf('Undefined device category Id: %s', $categoryId));
        }

        if (false === self::sanatizeItem(self::FILTER_TYPE_STRING, $categoryId)) {
            $validatorHandler->handleError(ValidationErrors::FILTER_INVALID_STRING, sprintf('Invalid device category Id. Must be a valid string'));
        }

        if ($this->withRepositories()) {
            if (null === $this->repositories) {
                $validatorHandler->handleError(ValidationErrors::UNDEFINED_REPOSITORY, 'Device identifier validation. Is required to set a repository to validate device identifier.');
                return;
            }

            if (null === $this->repositories->get('device_category')->categoryOfId($categoryId)) {
                $validatorHandler->handleError(ValidationErrors::NOT_FOUND_CATEGORY_ID, sprintf('Not found device category Id: %s', $categoryId));
            }

            $modelValidator = (new ModelValidator($this->configurations))->addRepositories($this->repositories);
            $modelValidator->validate($validatorHandler, $dto->model());

            foreach ($dto->deviceIdentifiers() as $deviceIdentifier) {
                $deviceIdentifierValidator = new DeviceIdentifierValidator($this->configurations);
                $deviceIdentifierValidator->validate($validatorHandler, $deviceIdentifier);
            }
            
            if (!$this->validNumberReferenceDeviceIdentifiers($dto->deviceIdentifiers())) {
                $validatorHandler->handleError(ValidationErrors::INVALID_NUMBER_REF_IDENTIFIERS, sprintf('Two many reference device identifiers. Must be one or none at all. If none is defined, by default is', $this->configurations->getParameter('application.ref_identifier_type')));
            }
        }
    }

    private function validNumberReferenceDeviceIdentifiers($deviceIdentifiers)
    {
        $countReferenceIdentifiers = 0;
        foreach ($deviceIdentifiers as $deviceIdentifier) {
            if ($deviceIdentifier->isReferenceIdentifier()) {
                $countReferenceIdentifiers++;
            }
        }
        
        return $countReferenceIdentifiers <= 1;
    }

    public function withRepositories(): bool
    {
        return true;
    }

}
