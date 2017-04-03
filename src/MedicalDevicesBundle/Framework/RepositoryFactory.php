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

use MedicalDevices\Infrastructure\Persistence\RepositoryInterface;

/**
 * Description of RepositoryFactory
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryFactory extends AbstractRepositoryFactory
{

    /**
     * Returns a repository instance
     * 
     * @param array $dependentServices
     * @return \MedicalDevicesBundle\Framework\className
     * @throws \Exception
     */
    public function create(array $dependentServices = array()): RepositoryInterface
    {
        $orm = $this->findORM();

        switch ($orm) {
            case 'Doctrine':
                if (array_search('serializer', $this->dependencies)) {
                    $repository = new $this->className($dependentServices['em'], $dependentServices['serializer']);
                } else {
                    $repository = new $this->className($dependentServices['em']);
                }
                
                break;
            case 'Json':              
                $repositoryFile = $dependentServices['init']->getParameter('infrastructure.db_json_files_path') . '/' . $dependentServices['init']->getParameter('infrastructure.db_json_files.'.$this->repositoryClass);
                $repository = new $this->className($repositoryFile);
                break;
                default :
                    throw new \Exception('Trying to create a repository');
        }
        
        return $repository;        
    }

}
