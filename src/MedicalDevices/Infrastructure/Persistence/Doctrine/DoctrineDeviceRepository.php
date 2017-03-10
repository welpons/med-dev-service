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

use MedicalDevices\Domain\Model\Device\DeviceRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\Query;

/**
 * Implementation of DeviceRepositoryInterface with Doctrine
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineDeviceRepository implements DeviceRepositoryInterface
{ 
    const ENTITY_CLASS = Device::class;
    
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function save(Device $device)
    {
        $this->em->persist($device);
        
        foreach($device->identifiers() as $deviceidentifier) {
            $this->em->persist($deviceidentifier);
        }
    }

    public function remove(Device $device)
    {
        $this->em->remove($device);         
    }

    public function nextIdentity()
    {
        return DeviceId::create();         
    }    

    public function allDevicesOfModel(Model $model)
    {
        return $this->em->createQueryBuilder()
                ->select('d')
                ->from(self::ENTITY_CLASS, 'd')
                ->where('d.model.id = :model_id')
                ->setParameter(':model_id', $model->id())                
                ->getQuery()
                ->getResult();          
    }

    public function allDevicesOfCategoryId($categoryId)
    {   
        return $this->em->createQueryBuilder()
                ->select('d')
                ->from(self::ENTITY_CLASS, 'd')
                ->where('d.categoryId = :category_id')
                ->setParameter(':category_id', $categoryId)                
                ->getQuery()
                ->getResult();             
    }

    public function allDevicesOfType(Type $type)
    {        
        return $this->em->createQueryBuilder()
                ->select('d')
                ->from(self::ENTITY_CLASS, 'd')
                ->where('d.model.type.key = :type_key')
                ->setParameter(':type_key', $type->key())                
                ->getQuery()
                ->getResult();           
    }

    public function deviceOfId(DeviceId $id)
    {
        return $this->em->createQueryBuilder()
                ->select('d, i')
                ->from(self::ENTITY_CLASS, 'd')
                ->leftJoin('d.identifiers', 'i')
                ->where('d.id = :id')
                ->setParameter(':id', $id->id())                
                ->getQuery()
                ->getOneOrNullResult('DeviceHydrator');  
    }

    public function allDevices()
    {
        return $this->em->createQueryBuilder()
                ->select('d')
                ->from(self::ENTITY_CLASS, 'd')            
                ->getQuery()
                ->getResult();     
    }

    public function getName(): string
    {
        return 'device';
    }

}
