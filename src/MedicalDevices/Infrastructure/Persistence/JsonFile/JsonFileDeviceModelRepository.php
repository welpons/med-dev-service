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

namespace MedicalDevices\Infrastructure\Persistence\JsonFile;

use MedicalDevices\Domain\Model\Device\Model\ModelRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of JsonFileDeviceModelRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileDeviceModelRepository extends JsonFileRepository implements ModelRepositoryInterface
{

    //put your code here
    public function allModels()
    {
        $objModels = [];
        foreach ($this->raws as $typeName => $models) {
            $type = new Type($models['key'], $typeName);            
            array_walk_recursive(
                $models, function ($value, $id) use (&$objModels, $type) {
                    if ($id === 'id') {
                        $model = new Model($value, $type);
                        $objModels[$value] = $model;
                    }
                }
            );
        }
        
        return $objModels;
    }

    public function modelOfId($id)
    {
        $objModel = null;
        foreach ($this->raws as $typeName => $models) {
            $typeKey = $models['key'];          
            array_walk_recursive(
                $models, function ($modelId) use (&$objModel, $typeName, $typeKey, $id) {
                    if ($modelId == $id) {
                        $objModel = new Model($modelId, new Type($typeKey, $typeName));
                    }
                }
            );
        }
        
        return $objModel;
    }

    public function getName(): string
    {
        return 'device_model';
    }

}
