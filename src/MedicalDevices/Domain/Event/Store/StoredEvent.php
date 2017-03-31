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

namespace MedicalDevices\Domain\Event\Store;

use MedicalDevices\Domain\DomainEventInterface;


/**
 * Description of MailedEvent
 *
 * @author Welpons <welpons@gmail.com>
 */
class StoredEvent implements DomainEventInterface
{
    /**
     *
     * @var integer 
     */
    private $eventId; 
    
    /**
     *
     * @var Object 
     */
    private $eventBody;
    
    /**
     *
     * @var \DateTimeImmutable 
     */
    private $occurredOn; 
    
    /**
     *
     * @var string 
     */
    private $typeName; 
    
    /** 
     * 
     * @param string $aTypeName 
     * @param \DateTimeImmutable $anOccurredOn 
     * @param string $anEventBody 
     */
    public function __construct(string $aTypeName, \DateTimeImmutable $anOccurredOn, $anEventBody) 
    { 
        $this->eventBody = $anEventBody; 
        $this->typeName = $aTypeName; 
        $this->occurredOn = $anOccurredOn; 
    } 
    
    public function eventBody() 
    { 
        return $this->eventBody; 
    } 
    
    public function eventId() 
    { 
        return $this->eventId; 
    } 
    
    public function typeName() 
    { 
        return $this->typeName;         
    } 
    
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;           
    }

}
