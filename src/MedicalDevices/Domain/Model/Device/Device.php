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

namespace MedicalDevices\Domain\Model\Device;

use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;

/**
 * Description of Device: Root aggregate
 *
 * @author Welpons <welpons@gmail.com>
 */
class Device
{

    /**
     * @var DeviceId 
     */
    private $id;

    /**
     *
     * @var string 
     */
    private $categoryId;

    /**
     *
     * @var Model 
     */
    private $model;

    /**
     *
     * @var string 
     */
    private $referenceIdentifierType;

    /**
     *
     * @var array
     */
    protected $deviceIdentifiers;

    /**
     * 
     * @param \MedicalDevices\Domain\Model\Device\DeviceId $id
     * @param string $categoryId
     * @param Model $model
     * @param string $referenceIdentifierType
     */
    public function __construct(DeviceId $id, string $categoryId, Model $model, string $referenceIdentifierType = null)
    {
        $this->deviceIdentifiers = [];
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->model = $model;
        $this->referenceIdentifierType = $referenceIdentifierType;
    }

    /**
     * 
     * @param \MedicalDevices\Domain\Model\Device\DeviceId $id
     * @param string $categoryId
     * @param string $modelId
     * @param string $modelTypeKey
     * @param string $referenceIdentifierType
     * @return \self
     */    
    public static function create(DeviceId $id, string $categoryId, string $modelId, string $modelTypeKey, string $referenceIdentifierType = null)
    {
        if (null === $id) {
            $id = DeviceId::create();
        }

        return new self($id, $categoryId, new Model($modelId, new Type($modelTypeKey)), $referenceIdentifierType);
    }

    /**
     * 
     * @param array <MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierRequestDTO>
     * @return $this
     * @throws MultipleReferenceDeviceIdentifiersException
     */
    public function setDeviceIdentifiers(array $deviceIdentifiers)
    {
        if (!empty($deviceIdentifiers)) {
            $this->deviceIdentifiers = [];
        }

        $countReferenceIdentifierTypes = 0;     
        foreach ($deviceIdentifiers as $deviceIdentifier) {           
            (true === $deviceIdentifier->isReferenceIdentifier() ? $countReferenceIdentifierTypes++ : $countReferenceIdentifierTypes);
        }

        if (0 == $countReferenceIdentifierTypes) {
            foreach ($deviceIdentifiers as $deviceIdentifier) {
                if ($this->referenceIdentifierType == $deviceIdentifier->type()) {
                    $deviceIdentifier->setIsReferenceIdentifier(DeviceIdentifier::IS_REFERENCE_ID);
                }
            }
        } elseif (1 < $countReferenceIdentifierTypes) {
            throw new MultipleReferenceDeviceIdentifiersException('Too many reference device identifiers. It is required only one or none at all');
        }

        foreach($deviceIdentifiers as $deviceIdentifier) {
            $this->deviceIdentifiers[] = new DeviceIdentifier(new Identifier($deviceIdentifier->type(), $deviceIdentifier->value()), $deviceIdentifier->isReferenceIdentifier(), $this);
        }
        
        return $this;
    }

    public function id(): DeviceId
    {
        return $this->id;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function deviceIdentifiers()
    {
        return $this->deviceIdentifiers;
    }

    public function __toString()
    {
        return $this->id->id();
    }

}
