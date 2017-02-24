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
use MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceTypeRepository;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of JsonFileTypeRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileDeviceTypeRepositoryTest extends KernelTestCase
{

    private $container;
    private $init;
    private $path;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->path = $this->init->getParameter('infrastructure.db_json_files_path') . '/device_models.json';
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_type_repo
     */
    public function getAllCategories()
    {
        $repository = new JsonFileDeviceTypeRepository($this->path);
        $allTypes = $repository->allTypes();

        $this->assertTrue(is_array($allTypes) && count($allTypes) > 0);

        $element = current($allTypes);
        $this->assertTrue($element instanceof Type);
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_type_repo
     */
    public function getTypeOfKey()
    {
        $repository = new JsonFileDeviceTypeRepository($this->path);
        $allTypes = $repository->allTypes();
        
        $typeOfId = $repository->typeOfKey('GLUCO');
        $this->assertTrue($typeOfId instanceof Type);
      
        $this->assertEquals($allTypes['glucometer'], $typeOfId);
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_type_repo
     */
    public function getTypeOfName()
    {
        $repository = new JsonFileDeviceTypeRepository($this->path);
        $allTypes = $repository->allTypes();
        
        $typeOfName = $repository->typeOfName('glucometer');
        $this->assertTrue($typeOfName instanceof Type);
        
        $this->assertEquals($allTypes['glucometer'], $typeOfName);
    }    
}
