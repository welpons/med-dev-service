<?php

namespace MedicalDevicesBundle\ExternalServices;

use JMS\Serializer\SerializerBuilder;
use MedicalDevices\Infrastructure\Service\External\SerializerServiceInterface;
use MedicalDevices\Configuration\ConfigurationInterface;

/**
 * Class used as service. It allows to denormalize: convert arrays into objects
 * This service is based on JMS Serializer
 */
class Serializer implements SerializerServiceInterface
{
    private $metaDataDir = null;    
    
    private $serializer = null;
    
    public function __construct(ConfigurationInterface $configurations)
    {
        $this->metaDataDir = $configurations->getParameter('infrastructure.jms_serializer_mapping_dir');
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
        $this->createSerializer();        
        
        return $this->serializer->deserialize($data, $type, $format);
    }

    public function serialize($data, $format)
    {
        $this->createSerializer();
        
        return $this->serializer->serialize($data, $format);
    }

    private function createSerializer()
    {
        if (null === $this->serializer) {
            $this->serializer = SerializerBuilder::create()->addMetadataDir($this->metaDataDir)->build();  
        }
    }        
}
