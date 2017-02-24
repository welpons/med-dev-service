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


/**
 * Description of JsonFileRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class JsonFileRepositoryTest extends KernelTestCase
{
    private $container;
    private $init;
    
    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
    }      

    /**
     * @test
     * @group infrastructure_persistence_jsonfile_repo
     * @expectedException MedicalDevices\Infrastructure\Persistence\JsonFile\UndefinedJsonFileException
     */
    public function undefinedPath()
    {
        $repository = $this
            ->getMockBuilder(JsonFileDeviceCategoryRepository::class)
            ->setConstructorArgs([''])    
            ->getMock();
    }  
    
    /**
     * @test
     * @group infrastructure_persistence_jsonfile_repo
     * @expectedException MedicalDevices\Infrastructure\Persistence\JsonFile\NotFoundJsonFileException
     */
    public function notFoundPath()
    {
        $repository = $this
            ->getMockBuilder(JsonFileDeviceCategoryRepository::class)
            ->setConstructorArgs(['not_found_path'])    
            ->getMock();
    }   
    
    /**
     * @test
     * @group infrastructure_persistence_jsonfile_repo
     * @expectedException MedicalDevices\Infrastructure\Persistence\JsonFile\DecodingJsonFileException
     */
    public function decodingJsonFileContent()
    {
        $repository = $this
            ->getMockBuilder(JsonFileDeviceCategoryRepository::class)
            ->setConstructorArgs([dirname(__FILE__) . '/test_file_wrong_format.json'])    
            ->getMock();
    }       
    
    /**
     * @test
     * @group infrastructure_persistence_jsonfile_repo
     */
    public function decodingEmptyJsonFileContent()
    {
        $class = new \ReflectionClass("MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceCategoryRepository");
        $property = $class->getProperty("raws");
        $property->setAccessible(true);

        $obj = new JsonFileDeviceCategoryRepository(dirname(__FILE__) . '/test_file_empty.json');
        $raws = $property->getValue($obj); 
        
        $this->assertTrue(is_array($raws) && empty($raws));
    }      
}
