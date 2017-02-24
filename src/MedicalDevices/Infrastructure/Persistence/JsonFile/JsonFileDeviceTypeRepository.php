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

use MedicalDevices\Domain\Model\Device\Model\Type\TypeRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of JsonFileDeviceTypeRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileDeviceTypeRepository extends JsonFileRepository implements TypeRepositoryInterface
{

    public function allTypes()
    {
        $types = [];

        foreach ($this->raws as $name => $value) {
            $types[$name] = new Type($value['key'], $name);
        }

        return empty($types) ? null : $types;
    }

    public function typeOfKey($key)
    {
        if (false === $index = array_search($key, array_column($this->raws, 'key'))) {
            return null;
        }

        $names = array_keys($this->raws);

        return new Type($key, $names[$index]);
    }

    public function typeOfName($name)
    {
        if (isset($this->raws[$name])) {
            return new Type($this->raws[$name]['key'], $name);
        }

        return null;
    }

    public function getName(): string
    {
        return 'device_type';
    }

}
