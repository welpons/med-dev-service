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

namespace MedicalDevices\Infrastructure\Persistence\DoctrineMongoDB;

use MedicalDevices\Domain\Model\Device\DeviceRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineRepository;

/**
 * Implementation of DeviceRepositoryInterface with Doctrine
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineMongoDBDeviceRepository extends DoctrineRepository implements DeviceRepositoryInterface
{
    
    public function allDevices($status = null) 
    {
        $sql = $this->em->createQueryBuilder()
            ->select('d')
            ->from(self::ENTITY_CLASS, 'd');
        
        if (null === $status || $status === Device::STATUS_ACTIVE) {
            $sql->where('d.deletedAt is NULL');       
        }

        if ($status === Device::STATUS_INACTIVE) {                 
            $sql->where('d.deletedAt != :deleted_at')
            ->setParameter(':deleted_at', null);           
        }        
            
        return $sql->getQuery()->getArrayResult();
    }

    public function allDevicesOfCategoryId($categoryId) 
    {
        
    }

    public function allDevicesOfModel(Model $model) 
    {
        
    }

    public function allDevicesOfType(Type $type) 
    {
        
    }

    public function deviceOfId(DeviceId $Id) 
    {
        
    }

    public function getName(): string 
    {
        
    }

    public function nextIdentity() 
    {
        
    }

    public function remove(Device $device) 
    {
        
    }

    public function save(Device $device) 
    {
        
    }

}




