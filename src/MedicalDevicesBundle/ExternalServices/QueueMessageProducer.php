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

namespace MedicalDevicesBundle\ExternalServices;

use MedicalDevices\Infrastructure\Service\External\MessageProducer;

/**
 * Description of QueueMessageProducer
 *
 * @author Welpons <welpons@gmail.com>
 */
class QueueMessageProducerr extends RabbitMqMessaging implements MessageProducer
{

    /** 
     * @param $exchangeName 
     * @param string             $notificationMessage 
     * @param string             $notificationType 
     * @param int                $notificationId 
     * @param \DateTimeImmutable $notificationOccurredOn 
     */
    public function send($exchangeName, $notificationMessage, $notificationType, $notificationId, \DateTimeImmutable $notificationOccurredOn)
    {
        $this->channel($exchangeName)->basic_publish(
            new AMQPMessage(
                $notificationMessage, ['type' => $notificationType,
                'timestamp' => $notificationOccurredOn->getTimestamp(),
                'message_id' => $notificationId
                ]
            ), $exchangeName
        );
    }



}
