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

namespace Tests\MedicalDevices\Infrastructure\Persistence;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Infrastructure\Persistence\RepositoryInterface;

/**
 * Description of RepositoryCollectionTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryCollectionTest extends KernelTestCase
{

    /**
     * @test
     * @group infrastructure_persitence_repositorycollection
     */
    public function add()
    {
        $repositoryMock = $this->createMock('MedicalDevices\Infrastructure\Persistence\RepositoryInterface');
        $repositoryMock->expects($this->any())
                ->method('getName')
                ->will($this->returnValue('foo'));        
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repositoryMock);

        $this->assertTrue(1 == $repositoryCollection->count());
    }
       
    /**
     * @test
     * @group infrastructure_persitence_repositorycollection
     */
    public function get()
    {
        $repositoryMock = $this->createMock('MedicalDevices\Infrastructure\Persistence\RepositoryInterface', array('getName'));
        $repositoryMock->expects($this->any())
                ->method('getName')
                ->will($this->returnValue('foo'));
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repositoryMock);

        $repository = $repositoryCollection->get('foo');
        $this->assertTrue($repository instanceof RepositoryInterface);
    }

    /**
     * @test
     * @group infrastructure_persitence_repositorycollection
     * @expectedException MedicalDevices\Infrastructure\Persistence\EmptyRepositoryCollectionException
     */
    public function getWithEmptyCollection()
    {
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->get('foo');
    }
    
    /**
     * @test
     * @group infrastructure_persitence_repositorycollection
     * @expectedException MedicalDevices\Infrastructure\Persistence\UndefinedRepositoryNameException
     */
    public function getRepositoryUndefinedName()
    {
        $repositoryMock = $this->createMock('MedicalDevices\Infrastructure\Persistence\RepositoryInterface', array('getName'));
        $repositoryMock->expects($this->any())
                ->method('getName')
                ->will($this->returnValue(''));
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repositoryMock);       
    }        

}
