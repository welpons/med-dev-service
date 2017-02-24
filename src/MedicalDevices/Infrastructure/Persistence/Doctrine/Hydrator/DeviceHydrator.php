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

namespace MedicalDevices\Infrastructure\Persistence\Doctrine\Hydrator;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use PDO;
use MedicalDevices\Domain\Model\Device\Device;
use MedicalDevices\Domain\Model\Device\DeviceId;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;

/**
 * Description of DeviceHydrator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceHydrator extends AbstractHydrator 
{     
    private $device = null;
    
    protected function hydrateAllData()     
    {         
        $result = array();                 
        foreach($this->_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->createDevice($row);
            $this->hydrateRowData($row, $result);
        }
        
        return $this->device->setIdentifiers($result);
    }

    protected function hydrateRowData(array $data, array &$result)
    {
        $deviceIdentifier = new DeviceIdentifier(new Identifier($data['identifier_type_6'], $data['identifier_value_7'], (1 == $data['is_reference_id_4']) ? true : false), $this->device);
        $result[] = $deviceIdentifier;
    }
    
    private function createDevice($row)
    {
        if (null === $this->device) {          
            $this->device = new Device(DeviceId::create($row['id_3']), $row['category_id_0'], $row['type_key_1'], $row['model_id_2']);
        }
    }        
}
