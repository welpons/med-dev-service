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

namespace Tests\MedicalDevices\Infrastructure\Persistence\DoctrineMongoDB;

use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;


/**
 * Description of LoadDeviceIdentifierData
 *
 * @author Welpons <welpons@gmail.com>
 */
class LoadDeviceData 
{

    private $refIdentifierType;
    
    public function __construct($refIdentifierType)
    {
        $this->refIdentifierType = $refIdentifierType;
    }    
    
    public function load() 
    {
        
        $createdAt = new \DateTimeImmutable();
        $device1 = new Device(DeviceId::create(), 'med', new Model('FORA_D40', new Type('GLUCO', 'glucometer')), $this->refIdentifierType, $createdAt, $createdAt, null);
        
        $device1->setDeviceIdentifier(new DeviceIdentifier(new Identifier('SNO', 'SN123456'), DeviceIdentifier::IS_NOT_REFERENCE_ID)); 
        $device1->setDeviceIdentifier(new DeviceIdentifier(new Identifier('MAC', '00:0a:95:9d:68:16'), DeviceIdentifier::IS_NOT_REFERENCE_ID));
        $device1->setDeviceIdentifier(new DeviceIdentifier(new Identifier('UID', 'b776da23-a9be-4b3a-9c7e-d359713fca58'), DeviceIdentifier::IS_REFERENCE_ID, $device1));

print_r($device1->toArray());    

        $m = new \MongoClient();

// seleccionar una base de datos
        $bd = $m->case;

// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
        $colección = $bd->Device;

// añadir un registro
        $documento = array('id', "categoryId" => "Bill Watterson");
        $colección->insert($documento);



// encontrar todo lo que haya en la colección
        $cursor = $colección->find();

// recorrer el resultado
        foreach ($cursor as $documento) {
            echo $documento["categoryId"] . "\n";
        }
    }

}
