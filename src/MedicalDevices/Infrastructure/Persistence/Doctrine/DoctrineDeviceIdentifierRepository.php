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

namespace MedicalDevices\Infrastructure\Persistence\Doctrine;

use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifierRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use Doctrine\ORM\Query;

/**
 * Description of DoctrineDeviceIdentifierRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineDeviceIdentifierRepository extends DoctrineRepository implements DeviceIdentifierRepositoryInterface
{
    const ENTITY_CLASS = DeviceIdentifier::class;
    
    
    public function allDeviceIdentifiers()
    {
        return $this->em->createQueryBuilder()
                        ->select('i')
                        ->from(self::ENTITY_CLASS, 'i')
                        ->getQuery()
                        ->getResult();        
    }    
    
    public function deviceIdentifierOfIdentifier(Identifier $identifier)
    {
        return $this->em->createQueryBuilder()
                ->select('i')
                ->from(self::ENTITY_CLASS, 'i')
                ->where('i.identifier.type = :type')
                ->andWhere('i.identifier.value = :value')
                ->setParameter(':type', $identifier->type())  
                ->setParameter(':value', $identifier->value())
                ->getQuery()
                ->getOneOrNullResult();          
    }

    public function deviceIdentifiersOfDevice(DeviceId $deviceId)
    {
        return $this->em->createQueryBuilder()
                ->select('d, i')
                ->from(self::ENTITY_CLASS, 'i')
                ->join('i.device', 'd')
                ->where('i.device = :device_id')
                ->orderBy('i.isReferenceIdentifier', 'DESC')
                ->setParameter(':device_id', $deviceId)
                ->getQuery()
                ->getResult();  
    }

    public function referenceDeviceIdentifierOfDevice(DeviceId $deviceId)
    {
        return $this->em->createQueryBuilder()
                ->select('d, i')
                ->from(self::ENTITY_CLASS, 'i')
                ->join('i.device', 'd')
                ->where('i.device = :device_id')
                ->andWhere('i.isReferenceIdentifier = :is_reference_id')
                ->setParameter(':device_id', $deviceId)
                ->setParameter(':is_reference_id', DeviceIdentifier::IS_REFERENCE_ID)
                ->getQuery()
                ->getOneOrNullResult();           
    }

    public function remove(DeviceIdentifier $deviceIdentifier)
    {
        $this->em->remove($deviceIdentifier);                 
    }

    public function save(DeviceIdentifier $deviceIdentifier)
    {
        $this->em->persist($deviceIdentifier);         
    }

    public function getName(): string
    {
        return 'device_identifier';
    }

}
