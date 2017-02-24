<?php

namespace AppBundle\Framework;

use JMS\Serializer\SerializerBuilder;
use MedicalDevices\Infrastructure\Service\External\SerializerService;

/**
 * Class used as service. It allows to denormalize: convert arrays into objects
 * This service is based on JMS Serializer
 * 
 */
class Serializer implements SerializerService
{
    private $metaDataDir = null;    
    private $serializer;
    
    public function __construct()
    {
        $this->metaDataDir = dirname(__FILE__) . '/../Resources/config/serializer/';
    }

    public function setMetadataDir(string $metaDataDir)
    {
        if (!is_dir($metaDataDir)) {
            throw new \InvalidArgumentException(sprintf('The directory "%s" does not exist.', $metaDataDir));
        }        
        
        $this->metaDataDir = $metaDataDir;           
        
        return $this;
    }        
    
    public function deserialize($data, $type, $format = 'xml')
    {
        $this->serializer = SerializerBuilder::create()->addMetadataDir($this->metaDataDir)->build();          
        
        return $this->serializer->deserialize($data, $type, $format);
    }

}
