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
use MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceModelRepository;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of JsonFileModelRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileDeviceModelRepositoryTest extends KernelTestCase
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
     * @group infrastructure_persistence_jsonfile_model_repo
     */
    public function getAllModels()
    {
        $repository = new JsonFileDeviceModelRepository($this->path);
        $allModels = $repository->allModels();

        $this->assertTrue(is_array($allModels) && count($allModels) > 0);

        $element = current($allModels);
        $this->assertTrue($element instanceof Model);
    }

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_model_repo1
     */
    public function getModelOfId()
    {
        $repository = new JsonFileDeviceModelRepository($this->path);
        $allModels = $repository->allModels();
        
        $modelOfId = $repository->modelOfId('FORA_D40');
        $this->assertTrue($modelOfId instanceof Model);
        
        $this->assertEquals($allModels['FORA_D40'], $modelOfId);
        $this->assertEquals($modelOfId->type(), new Type('GLUCO', 'glucometer'));
    }


}
