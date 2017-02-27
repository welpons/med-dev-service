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

namespace MedicalDevices\Infrastructure\Persistence\JMSSerializer;

use MedicalDevices\Infrastructure\Service\External\SerializerServiceInterface;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModelRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel;
/**
 * Description of JMSSerializerMedDeviceModelRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JMSSerializerMedDeviceModelRepository implements MedDeviceModelRepositoryInterface
{
    const CLASS_NAME = 'MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel';
    
    private $serializer;
    private $path;
    
    public function __construct(SerializerServiceInterface $serializer, string $path)
    {
        $this->serializer = $serializer;
        $this->path = $path;
    }

    public function medDeviceModelOfId(Model $model): MedDeviceModel
    {
        $fileName = "{$this->path}{$model->id()}.xml";
        
        if (!file_exists($fileName)) {
            throw new MedDeviceModelFileNotExistException(sprintf('Medical device model file does not exist %s in dir: %s', "{$model->id()}.xml", $this->path));
        }
        
        try {
            $data = file_get_contents($fileName);
            $medDeviceModel = $this->serializer->deserialize($data, self::CLASS_NAME);
        } catch (Exception $ex) {
            throw new SerializationException(sprintf('Error trying to deserialize file: %s. Error: %s', $fileName, $ex->getMessage()));
        }
        
        return $medDeviceModel;
    }

    public function getName(): string
    {
        return 'med_device_model';
    }    
}
