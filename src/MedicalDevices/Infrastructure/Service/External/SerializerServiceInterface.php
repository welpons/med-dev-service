<?php

namespace MedicalDevices\Infrastructure\Service\External;

/**
 *
 * @author jenkins
 */
interface SerializerServiceInterface
{    
    public function deserialize($data, $type, $format); 
}
