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

use AMQPExchange;
use AMQPExchangeException;
use BadMethodCallException;

/**
 * Description of AmqpMessageProducer
 *
 * @author Welpons <welpons@gmail.com>
 */
class RabbitMqMessageProducer extends RabbitMqMessaging implements MessageProducerInterface
{


    /**
     * @param $exchangeName 
     * @param string $notificationMessage 
     * @param string $notificationType 
     * @param int $notificationId 
     * @param \DateTimeImmutable $notificationOccurredOn 
     */
    public function send($exchangeName, $notificationMessage, $notificationType, $notificationId, \DateTimeImmutable $notificationOccurredOn)
    {
        $this->channel($exchangeName)->basic_publish(
                new AMQPMessage(
                $notificationMessage, [
                    'type' => $notificationType,
                    'timestamp' => $notificationOccurredOn->getTimestamp(),
                    'message_id' => $notificationId
                ]
                ), $exchangeName
        );
    }

}
