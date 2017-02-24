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

namespace Tests\MedicalDevices\Infrastructure\Persistence\JsonFile;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceCategoryRepository;
use MedicalDevices\Domain\Model\Device\Category\Category;

/**
 * Description of JsonFileCategoryRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileDeviceCategoryRepositoryTest extends KernelTestCase
{

    private $container;
    private $init;
    private $path;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->path = $this->init->getParameter('infrastructure.db_json_files_path') . '/device_categories.json';
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_category_repo
     */
    public function getAllCategories()
    {
        $repository = new JsonFileDeviceCategoryRepository($this->path);
        $allCategories = $repository->allCategories();

        $this->assertTrue(is_array($allCategories) && count($allCategories) > 0);

        $element = current($allCategories);
        $this->assertTrue($element instanceof Category);
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_category_repo
     */
    public function getCategoryOfId()
    {
        $repository = new JsonFileDeviceCategoryRepository($this->path);
        $allCategories = $repository->allCategories();
        
        $categoryOfId = $repository->categoryOfId('med');
        $this->assertTrue($categoryOfId instanceof Category);
        
        $this->assertEquals($allCategories['medical'], $categoryOfId);
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_category_repo
     */
    public function getCategoryOfName()
    {
        $repository = new JsonFileDeviceCategoryRepository($this->path);
        $allCategories = $repository->allCategories();
        
        $categoryOfName = $repository->categoryOfName('medical');
        $this->assertTrue($categoryOfName instanceof Category);
        
        $this->assertEquals($allCategories['medical'], $categoryOfName);
    }    
}
