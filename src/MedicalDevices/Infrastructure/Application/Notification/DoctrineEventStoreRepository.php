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

namespace MedicalDevices\Infrastructure\Application\Notification;

/**
 * Description of DoctrineEventStore
 *
 * @author Welpons <welpons@gmail.com>
 */
use MedicalDevices\Application\EventStoreInterface;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MedicalDevices\Infrastructure\Service\External\SerializerServiceInterface;
use MedicalDevices\Domain\Event\Store\StoredEvent;
use MedicalDevices\Domain\Event\Store\StoredEventRepositoryInterface;
use Doctrine\ORM\EntityManager;

class DoctrineEventStoreRepository extends DoctrineRepository implements EventStoreInterface, StoredEventRepositoryInterface
{
    const ENTITY_CLASS = StoredEvent::class;
    
    private $serializer;

    public function __construct(EntityManager $em, SerializerServiceInterface $serializer)
    {
        parent::__construct($em);
        $this->serializer = $serializer;
    }

    public function append($aDomainEvent)
    {
        $storedEvent = new StoredEvent(
                get_class($aDomainEvent), $aDomainEvent->occurredOn(), $this->serializer->serialize($aDomainEvent, 'json')
        );
        
        $this->em->persist($storedEvent);
        $this->em->flush($storedEvent);
    }

    public function allStoredEventsSince(int $anEventId)
    {
        $query = $this->createQueryBuilder('e');
        
        if ($anEventId) {
            $query->where('e.eventId > :eventId');
            $query->setParameters(array('eventId' => $anEventId));
        }
        $query->orderBy('e.eventId');
        
        return $query->getQuery()->getResult();
    }

    public function getName(): string
    {
        return 'event_store';
    }

}
