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

use MedicalDevices\Infrastructure\Service\External\SerializerServiceInterface;
use MedicalDevices\Configuration\ConfigurationInterface;
use Doctrine\ORM\EntityManagerInterface;
use MedicalDevices\Infrastructure\Persistence\RepositoryInterface;

/**
 * Description of RepositoryFactory
 *
 * @author Welpons <welpons@gmail.com>
 */
abstract class AbstractRepositoryFactory
{    
    /**
     * @var string 
     */
    protected $className;
    
    /**
     * @var array 
     */
    protected $dependencies;
    
    /**
     * @var string 
     */
    protected $repositoryClass;
    
    /**
     * 
     * @param string $className
     * @param array $dependencies
     */
    public function __construct(string $className, array $dependencies = [])
    {
        $this->setClassName($className);
        $this->dependencies = $dependencies;        
    }    
    
    /**
     * creates an instance of a repository using its dependencies
     * 
     * @param array $dependentServices
     * @return RepositoryInterface
     */
    abstract public function create(array $dependentServices = []) : RepositoryInterface;
        
    public function hasDependencies()
    {
        return count($this->dependencies) > 0;
    }        
    
    public function getDependencies()
    {
        return $this->dependencies;
    }        
    
    protected function setClassName(string $className)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('Repository class not found: %s', $className));
        }     

        $this->className = $className;
    }        
    
    /**
     * All repository classes start with a key word: 'Doctrine', 'Json'. This method
     * finds these key words 
     * 
     * @return type
     * @throws \Exception
     */
    protected function findORM(): string
    {
        try {
            $parts = explode("\\", $this->className);
            $this->repositoryClass = end($parts);
            
            preg_match_all('/((?:^|[A-Z])[a-z]+)/',$this->repositoryClass, $matches);
            
            if (empty($matches)) {
                throw new \Exception('Unknown ORM');
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        
        return $matches[0][0];
    }        
    
}
