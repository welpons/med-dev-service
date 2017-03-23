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
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceIdentifierRepository;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceRepository;
use MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceCategoryRepository;
use MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceModelRepository;
use MedicalDevices\Infrastructure\Persistence\JsonFile\JsonFileDeviceTypeRepository;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Configuration\ConfigurationInterface;
use Doctrine\ORM\EntityManager;

/**
 * Description of RepositoryCollectionProvider
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryCollectionProvider implements RepositoriesProvider
{
    private $repositoryCollection;
    
    public function __construct(ConfigurationInterface $configuration, EntityManager $entityManager)
    {
        $this->repositoryCollection = new RepositoryCollection();
        $this->repositoryCollection->add(new DoctrineDeviceRepository($entityManager));
        $this->repositoryCollection->add(new DoctrineDeviceIdentifierRepository($entityManager));
        $this->repositoryCollection->add(new JsonFileDeviceCategoryRepository($configuration->getParameter('infrastructure.db_json_files_path') . '/device_categories.json'));        
        $this->repositoryCollection->add(new JsonFileDeviceModelRepository($configuration->getParameter('infrastructure.db_json_files_path') . '/device_models.json'));
        $this->repositoryCollection->add(new JsonFileDeviceTypeRepository($configuration->getParameter('infrastructure.db_json_files_path') . '/device_models.json'));        
    }
    
    public function getCollection()
    {
        return $this->repositoryCollection;
    }        
}
