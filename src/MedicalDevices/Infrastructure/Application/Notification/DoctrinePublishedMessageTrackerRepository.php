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

use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MedicalDevices\Application\Service\Notification\PublishedMessageTrackerInterface;
use MedicalDevices\Domain\Event\PublishedMessage;
use MedicalDevices\Domain\DomainEventInterface;

/**
 * Description of DoctrinePublishedMessageTrackerRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrinePublishedMessageTrackerRepository extends DoctrineRepository implements PublishedMessageTrackerInterface
{
    const ENTITY_CLASS = PublishedMessage::class;
    
    /**
     * @param $aTypeName
     * @return int
     */
    public function mostRecentPublishedMessageId($aTypeName)
    {
        $messageTracked = $this->messageTrackerOfTypeName($aTypeName);
        if (!$messageTracked) {
            return null;
        }
        
        return $messageTracked->mostRecentPublishedMessageId();
    }
    /**
     * @param $aTypeName
     * @param StoredEvent $notification
     */
    public function trackMostRecentPublishedMessage($aTypeName, DomainEventInterface $notification)
    {
        if (!$notification) {
            return;
        }
        
        $maxId = $notification->eventId();
        $publishedMessage = $this->messageTrackerOfId($aTypeName);
        if (!$publishedMessage) {
            $publishedMessage = new PublishedMessage(
                $aTypeName,
                $maxId
            );
        }
        
        $publishedMessage->updateMostRecentPublishedMessageId($maxId);
        $this->em->persist($publishedMessage);
        $this->em->flush($publishedMessage);
    }

    public function getName(): string
    {
        return 'published_msg_tracker';
    }

    public function messageTrackerOfId($trackerId)
    {
        return $this->em->createQueryBuilder()
                ->select('mt')
                ->from(self::ENTITY_CLASS, 'mt')
                ->where('mt.trackerId = :tracker_id')
                ->setParameter(':tracker_id', $trackerId)  
                ->getQuery()
                ->getOneOrNullResult();           
    }

    public function messageTrackerOfTypeName($aTypeName)
    {
        return $this->em->createQueryBuilder()
                ->select('mt')
                ->from(self::ENTITY_CLASS, 'mt')
                ->where('mt.typeName = :type_name')
                ->setParameter(':type_name', $aTypeName)  
                ->getQuery()
                ->getOneOrNullResult();         
    }

}

