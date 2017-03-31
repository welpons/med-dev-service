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

namespace Tests\AppBundle\Request;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Request\Publisher;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Domain\DomainEventPublisher;
use MedicalDevices\Domain\DomainEventSubscriberInterface;

/**
 * Description of PublisherTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class PublisherTest extends KernelTestCase
{
    private $container;
    private $repositoryCollection;
    
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    } 
    
    /**
     * @test
     * @group appbundle_request
     * @group appbundle_request_publisher
     */
    public function checkRepositoriesPropertyType()
    {
        $publisher = new Publisher($this->container);
        
        $reflection = new \ReflectionObject($publisher);
        $repositoriesProperty = $reflection->getProperty('repositories');
        $repositoriesProperty->setAccessible(true); 

        $this->assertTrue($repositoriesProperty->getValue($publisher) instanceof RepositoryCollection);
    }        
    
    /**
     * @test
     * @group appbundle_request
     * @group appbundle_request_publisher
     */    
    public function checkSubscriptions()
    {
        $publisher = new Publisher($this->container);
        $request = Request::create('/test');
        $event = new GetResponseEvent(self::$kernel, $request, HttpKernelInterface::MASTER_REQUEST);
        
        $publisher->onKernelRequest($event);
        
        $this->assertTrue(DomainEventPublisher::instance()->ofId(0) instanceof DomainEventSubscriberInterface);
    }        
}
