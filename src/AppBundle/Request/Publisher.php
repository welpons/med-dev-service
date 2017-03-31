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

namespace AppBundle\Request;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MedicalDevices\Domain\DomainEventPublisher;
use MedicalDevices\Domain\PersistDomainEventSubscriber;


/**
 * In This class, the publisher adds subscribers.
 *
 * @author Welpons <welpons@gmail.com>
 */
class Publisher
{
    protected $container;
    private $repositories;

    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
        $this->repositories = $this->container->get('repository.collection.provider')->getCollection();
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        DomainEventPublisher::instance()->subscribe(new PersistDomainEventSubscriber($this->repositories->get('event_store')));
    }


}