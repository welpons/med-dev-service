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
use MedicalDevicesBundle\Framework\RepositoryCollectionProvider;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineRepository;

/**
 * Description of RepositoryCollectionProviderTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryCollectionProviderTest extends KernelTestCase
{
    private $container;
    private $init;
    private $em;
    private $serializer;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->serializer = $this->container->get('ext.services.serializer');
    }
    
    /**
     * @test
     * @group meddevicesbundle_framework_repocollectionprovider
     */
    public function getCollection()
    {
        $repositoryFactoryDoctrine = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\DoctrineTestRepository', ['em']);  
        $repositoryFactoryJsonFile = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\JsonFileTestRepository', ['init']);  
        $repoCollectionProvider = new RepositoryCollectionProvider($this->init, $this->em, $this->serializer);
        $repoCollectionProvider->addRepositoryFactory($repositoryFactoryDoctrine);
        $repoCollectionProvider->addRepositoryFactory($repositoryFactoryJsonFile);
        
        $repositoryCollection = $repoCollectionProvider->getCollection();
        $this->assertTrue($repositoryCollection instanceof RepositoryCollection);
    } 
    
    /**
     * @test
     * @group meddevicesbundle_framework_repocollectionprovider
     */    
    public function getRepositoryFromCollection()
    {
        $repositoryFactory = new RepositoryFactory('Tests\MedicalDevicesBundle\Framework\DoctrineTestRepository', ['em']);     
        $repoCollectionProvider = new RepositoryCollectionProvider($this->init, $this->em, $this->serializer);
        $repoCollectionProvider->addRepositoryFactory($repositoryFactory);
        $repositoryCollection = $repoCollectionProvider->getCollection();   
        $deviceRepository = $repositoryCollection->get('test_doctrine');
        
        $this->assertTrue($deviceRepository instanceof DoctrineRepository);
    }     
    
    /**
     * @test
     * @group meddevicesbundle_framework_repocollectionprovider1
     */
    public function getAsService()
    {
        $service = $this->container->get('repository.collection.provider');
        
        $this->assertTrue($service instanceof RepositoryCollectionProvider);
        $collection = $service->getCollection();
        
        $serviceIds = $this->container->getServiceIds();
        
        $repositoryServices = array_filter($serviceIds, function($v, $k) {      
            return 0 === strpos($v, 'repository.factory.');
        }, ARRAY_FILTER_USE_BOTH);
        
        $this->assertEquals($collection->count(), count($repositoryServices));
    }        
}
