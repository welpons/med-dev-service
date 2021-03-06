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
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_UNKNOWN = 9;
    
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
     * @var MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier 
     */
    private $referenceDeviceIdentifier;

    /**
     *
     * @var array
     */
    private $deviceIdentifiers;

    /**
     *
     * @var \DateTimeInterface 
     */
    private $createdAt;
    
    /**
     *
     * @var \DateTimeInterface 
     */
    private $updatedAt;

    /**
     *
     * @var \DateTimeInterface 
     */
    protected $deletedAt;
    
    /**
     * 
     * @param \MedicalDevices\Domain\Model\Device\DeviceId $id
     * @param string                                       $categoryId
     * @param Model                                        $model
     * @param string                                       $referenceIdentifierType
     * @param \DateTimeInterface                           $createdAt
     * @param \DateTimeInterface                           $updatedAt
     * @param \DateTimeInterface                           $deletedAt
     */
    public function __construct(DeviceId $id, string $categoryId, Model $model, string $referenceIdentifierType = null, \DateTimeInterface $createdAt = null, \DateTimeInterface $updatedAt = null, \DateTimeInterface $deletedAt = null)
    {
        $this->deviceIdentifiers = [];
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->model = $model;
        $this->referenceIdentifierType = $referenceIdentifierType;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    /**
     * 
     * @param \MedicalDevices\Domain\Model\Device\DeviceId $id
     * @param string                                       $categoryId
     * @param string                                       $modelId
     * @param string                                       $modelTypeKey
     * @param string                                       $referenceIdentifierType
     * @return \self
     */    
    public static function create(DeviceId $id, string $categoryId, string $modelId, string $modelTypeKey, string $referenceIdentifierType = null)
    {
        if (null === $id) {
            $id = DeviceId::create();
        }

        return new self($id, $categoryId, new Model($modelId, new Type($modelTypeKey)), $referenceIdentifierType, new \DateTimeImmutable());
    }

    /**
     * @param DeviceIdentifier $deviceIdentifier
     */
    public function setDeviceIdentifier(DeviceIdentifier $deviceIdentifier)
    {
        $this->deviceIdentifiers[] = $deviceIdentifier;
    }        
    
    /**
     * 
     * @param array <MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifier>
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
                if ($this->referenceIdentifierType == $deviceIdentifier->identifier()->type()) {
                    $deviceIdentifier->setIsReferenceIdentifier(DeviceIdentifier::IS_REFERENCE_ID);
                }
            }
        } elseif (1 < $countReferenceIdentifierTypes) {
            throw new MultipleReferenceDeviceIdentifiersException('Too many reference device identifiers. It is required only one or none at all');
        }

        foreach($deviceIdentifiers as $deviceIdentifier) {
            if ($deviceIdentifier->isReferenceIdentifier()) {
                $this->referenceDeviceIdentifier = $deviceIdentifier;
            }
            $this->setDeviceIdentifier($deviceIdentifier);
        }
        
        return $this;
    }

    public function changeReferenceDeviceIdentifier(Identifier $identifier)
    {
        foreach($this->deviceIdentifiers as $deviceIdentifier) {
            $deviceIdentifier->setIsReferenceIdentifier(DeviceIdentifier::IS_NOT_REFERENCE_ID);
        }          
        
        foreach($this->deviceIdentifiers as $deviceIdentifier) {
            if ($deviceIdentifier->identifier()->equals($identifier)) {
                $deviceIdentifier->setIsReferenceIdentifier(DeviceIdentifier::IS_REFERENCE_ID);
                $this->referenceDeviceIdentifier = $deviceIdentifier;
            }
        }    
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

    public function getReferenceDeviceIdentifier(): DeviceIdentifier
    {
        return $this->referenceDeviceIdentifier;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    public function setDeletedAt(\DateTimeInterface $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;
    }
        
    public function __toString()
    {
        return $this->id->id();
    }
    
    public function toArray()
    {
        return [
            'id' => $this->id,
            'Model' => $this->model->toArray(),
            'referenceIdentifierType' => $this->referenceIdentifierType,
            'deviceIdentifiers' => array_walk($this->deviceIdentifiers, function($value, $key) {
                return $value->toArray();
            }),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'deletedAt' => (null === $this->deletedAt ? :$this->deletedAt->format('Y-m-d H:i:s'))
        ];
    }        

}
