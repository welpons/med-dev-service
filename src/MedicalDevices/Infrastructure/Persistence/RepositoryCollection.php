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

namespace MedicalDevices\Infrastructure\Persistence;

/**
 * Description of RepositoryCollection
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryCollection implements \Iterator
{
    private $collection;
    
    public function current()
    {
         return current($this->collection);
    }

    public function key(): \scalar
    {
        return key($this->collection);
    }

    public function next(): void
    {
        next($this->collection);
    }

    public function rewind(): void
    {
        reset($this->collection);
    }

    public function valid(): bool
    {
        return key($this->collection) !== null;
    }

    public function add(RepositoryInterface $repository)
    {
        $repositoryName = $repository->getName();
        
        if (empty($repositoryName)) {
            throw new UndefinedRepositoryNameException(sprintf('Undefined repository name'));
        }
        
        $this->collection[$repository->getName()] = $repository;
    }   
    
    public function get(string $name)
    {        
        if (0 == $this->count()) {
            throw new EmptyRepositoryCollectionException('Repository collection is empty');
        }
        
        if (isset($this->collection[$name])) {
            return $this->collection[$name];
        }        
        
        throw new NotFoundRepositoryNameException(sprintf('Repository not found with name: %s', $name));
    }     
    
    public function count()
    {
        return count($this->collection);
    }        
}
