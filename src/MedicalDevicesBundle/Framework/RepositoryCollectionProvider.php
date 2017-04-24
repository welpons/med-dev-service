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

namespace MedicalDevicesBundle\Framework;

use MedicalDevices\Infrastructure\Persistence\RepositoriesProvider;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Infrastructure\Service\External\SerializerServiceInterface;
use MedicalDevices\Configuration\ConfigurationInterface;
use Doctrine\ORM\EntityManagerInterface;


/**
 * This class provides a collection of all repositories
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryCollectionProvider implements RepositoriesProvider
{
    private $repositoryCollection;
    private $repositoryFactoryCollection = [];
    private $dependentServices = [];
    
    /**
     * 
     * @param ConfigurationInterface     $configuration
     * @param EntityManagerInterface     $entityManager
     * @param SerializerServiceInterface $serializer
     */
    public function __construct(ConfigurationInterface $configuration, EntityManagerInterface $entityManager, SerializerServiceInterface $serializer)
    {
        $this->repositoryCollection = new RepositoryCollection();
        $this->dependentServices['em'] = $entityManager;
        $this->dependentServices['init'] = $configuration;
        $this->dependentServices['serializer'] = $serializer;
    }
    
    public function addRepositoryFactory(RepositoryFactory $repositoryFactory)
    {        
        $this->repositoryFactoryCollection[] = $repositoryFactory;
    }        
    
    private function generateRepositoryCollection()
    {
        if (!empty($this->repositoryFactoryCollection)) {
            foreach ($this->repositoryFactoryCollection as $repositoryCollection) {
                $this->repositoryCollection->add($repositoryCollection->create($this->dependentServices));
            }
        }
    }    
    
    public function getCollection()
    {
        $this->generateRepositoryCollection();
        
        return $this->repositoryCollection;
    }

}
