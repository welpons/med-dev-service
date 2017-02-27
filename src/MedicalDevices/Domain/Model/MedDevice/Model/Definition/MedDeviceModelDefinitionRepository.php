<?php

namespace MedicalDevices\Domain\Model\MedDevice\Model\Definition;

/**
 * Description of MedDeviceModelDefinitionRepository
 *
 * @author jenkins
 */
interface MedDeviceModelDefinitionRepository
{
    public function findOneByModelKey(string $key);        
}
