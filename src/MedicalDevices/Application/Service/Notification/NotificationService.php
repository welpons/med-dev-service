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

namespace MedicalDevices\Application\Service\Notification;

use MedicalDevices\Infrastructure\Service\External\SerializerServiceInterface;
use MedicalDevices\Application\Service\Notification\PublishedMessageTrackerInterface;
use MedicalDevices\Application\Service\Notification\MessageProducerInterface;
use MedicalDevices\Application\EventStoreInterface;

/**
 * Description of NotificationService
 *
 * @author Welpons <welpons@gmail.com>
 */
class NotificationService
{

    private $serializer;
    private $eventStore;
    private $publishedMessageTracker;
    private $messageProducer;

    public function __construct(EventStoreInterface $anEventStore, PublishedMessageTrackerInterface $aPublishedMessageTracker, MessageProducerInterface $aMessageProducer, SerializerServiceInterface $serializer)
    {
        $this->eventStore = $anEventStore;
        $this->publishedMessageTracker = $aPublishedMessageTracker;
        $this->messageProducer = $aMessageProducer;
        $this->serializer = $serializer;
    }

    /**
     * @return int
     */
    public function publishNotifications($exchangeName)
    {
        $publishedMessageTracker = $this->publishedMessageTracker();
        $notifications = $this->listUnpublishedNotifications($publishedMessageTracker->mostRecentPublishedMessageId($exchangeName));
        
        if (!$notifications) {
            return 0;
        }
        
        $messageProducer = $this->messageProducer();
        $messageProducer->open($exchangeName);
        
        try {
            $publishedMessages = 0;
            $lastPublishedNotification = null;
            foreach ($notifications as $notification) {
                $lastPublishedNotification = $this->publish($exchangeName, $notification, $messageProducer);
                $publishedMessages++;
            }
        } catch (\Exception $e) {
            
        }
        
        $this->trackMostRecentPublishedMessage($publishedMessageTracker, $exchangeName, $lastPublishedNotification);
        $messageProducer->close($exchangeName);
        
        return $publishedMessages;
    }

    /**
     * @return PublishedMessageTracker
     */
    protected function publishedMessageTracker()
    {
        return $this->publishedMessageTracker;
    }

    /**
     * @param $mostRecentPublishedMessageId
     * @return StoredEvent[]
     */
    private function listUnpublishedNotifications($mostRecentPublishedMessageId)
    {
        $storeEvents = $this->eventStore()->allStoredEventsSince($mostRecentPublishedMessageId);

        return $storeEvents;
    }

    /**
     * @return EventStore
     */
    protected function eventStore()
    {
        return $this->eventStore;
    }

    private function messageProducer()
    {
        return $this->messageProducer;
    }

    private function publish($exchangeName, StoredEvent $notification, MessageProducer $messageProducer)
    {
        $messageProducer->send(
            $exchangeName, $this->serializer->serialize($notification, 'json'), $notification->typeName(), $notification->eventId(), $notification->occurredOn()
        );
        
        return $notification;
    }

    private function trackMostRecentPublishedMessage(PublishedMessageTracker $publishedMessageTracker, $exchangeName, $notification)
    {
        $publishedMessageTracker->trackMostRecentPublishedMessage($exchangeName, $notification);
    }

}
