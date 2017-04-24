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
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;
use MedicalDevices\Application\DTO\Device\Identifier\DeviceIdentifierRequestDTO;

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
        
        return $this->device->setDeviceIdentifiers($result);
    }

    protected function hydrateRowData(array $data, array &$result)
    {       
        $deviceIdentifier = new DeviceIdentifierRequestDTO($data['identifier_type_6'], $data['identifier_value_7'], ((1 == $data['is_reference_id_4']) ? true : false));
        $result[] = $deviceIdentifier;
    }
    
    private function createDevice($row)
    {       
        if (null === $this->device) {          
            $this->device = new Device(DeviceId::create($row['id_1']), $row['category_id_0'], new Model($row['model_id_2'], new Type($row['model_type_key_3'])));
        }
    }        
}
