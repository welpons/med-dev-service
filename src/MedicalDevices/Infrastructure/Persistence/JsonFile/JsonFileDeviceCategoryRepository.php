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

use MedicalDevices\Domain\Model\Device\Category\CategoryRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Category\Category;

/**
 * Description of JsonFileDeviceCategoryRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileDeviceCategoryRepository extends JsonFileRepository implements CategoryRepositoryInterface
{

    public function allCategories()
    {
        $categories = [];
        
        foreach($this->raws as $name => $id) {
            $categories[$name] = new Category($id, $name);
        }
        
        return empty($categories) ? null : $categories;
    }

    public function categoryOfId($id)
    {
        $ids = array_flip($this->raws);
        
        if (isset($ids[$id])) {
            return new Category($id, $ids[$id]);
        }
        
        return null;
    }

    public function categoryOfName($name)
    {
        if (isset($this->raws[$name])) {
            return new Category($this->raws[$name], $name);
        }
        
        return null;        
    }

    public function getName(): string
    {
        return 'device_category';
    }

}
