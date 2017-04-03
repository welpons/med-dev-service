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

namespace Tests\MedicalDevicesBundle\Framework;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevicesBundle\Framework\RepositoryFactory;
use MedicalDevicesBundle\Framework\AbstractRepositoryFactory;

/**
 * Description of RepositoryFactory
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryFactoryTest extends KernelTestCase
{
    private $container;
    private $ini;
    private $serializer;
    private $em;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->em = $this->container->get('doctrine')->getManager();
        $this->serializer = $this->container->get('ext.services.serializer');
    }
    
    /**
     * @test
     * @group meddevicesbundle_framework_repositoryfactory
     */    
    public function doctrineRepository()
    {
        $repositoryFactory = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\DoctrineTestRepository', ['em']);
        $this->assertTrue($repositoryFactory instanceof AbstractRepositoryFactory);
    }   
    
    /**
     * @test
     * @group meddevicesbundle_framework_repositoryfactory
     */    
    public function doctrineRepositoryHasDependencies()
    {
        $repositoryFactory = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\DoctrineTestRepository', ['em']);
        $this->assertTrue($repositoryFactory->hasDependencies());
    }      
    
    /**
     * @test
     * @group meddevicesbundle_framework_repositoryfactory
     */   
     public function findORM()
     {
        $repositoryFactory = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\DoctrineTestRepository');
        
        $reflectionClass = new \ReflectionClass($repositoryFactory);
        $reflectionMethod = $reflectionClass->getMethod('findORM');
        $reflectionMethod->setAccessible(true);       
        
        $orm = $reflectionMethod->invokeArgs($repositoryFactory, []);     
       
        $this->assertEquals($orm, 'Doctrine');
     }       

    /**
     * @test
     * @group meddevicesbundle_framework_repositoryfactory
     */   
     public function getAsServiceContainer()
     {
         $service = $this->container->get('repository.factory.test');
         
         $this->assertTrue($service instanceof RepositoryFactory);
     }        
     
    /**
     * @test
     * @group meddevicesbundle_framework_repositoryfactory
     */   
     public function jsonRepository()
     {
         $repositoryFactory = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\JsonFileTestRepository', ['init' => null, 'file' => 'device_models.json']);
         $this->assertTrue($repositoryFactory instanceof AbstractRepositoryFactory);
     }        
}
