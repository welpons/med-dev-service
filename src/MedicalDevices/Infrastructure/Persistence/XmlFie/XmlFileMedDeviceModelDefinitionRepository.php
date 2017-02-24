<?php

namespace MedicalDevices\Infrastructure\Persistence\XmlFile;

use MedicalDevices\Domain\Model\Device\MedDevice\Model\Definition\MedDeviceModelDefinitionRepository;

/**
 * Description of MedDeviceModelDefinitionRepository
 *
 * @author jenkins
 */
class XmlFileMedDeviceModelDefinitionRepository implements MedDeviceModelDefinitionRepository
{
    public function __construct($serializer);
    
    //put your code here
    public function findOneByModelKey(string $key)
    {
        
    }


}
