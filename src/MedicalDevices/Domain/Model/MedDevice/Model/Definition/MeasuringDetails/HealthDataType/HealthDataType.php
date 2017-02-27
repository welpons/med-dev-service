<?php

namespace MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType;

/**
 * Description of HealthDataType
 *
 * @author jenkins
 */
class HealthDataType
{
    /**
     *
     * @var string 
     */
    private $key;
    
    /**
     * @var array<MedicalDevices\Domain\Model\Device\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit\Unit>
     */
    private $measurementUnits;
        
    public function key(): string
    {
        return $this->key;
    }

    public function measurementUnits(): array
    {
        return $this->measurementUnits;
    }    
}
