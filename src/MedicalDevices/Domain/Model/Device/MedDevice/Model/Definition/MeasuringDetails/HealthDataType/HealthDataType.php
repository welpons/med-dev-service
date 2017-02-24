<?php

namespace MedicalDevices\Domain\Model\Device\MedDevice\Model\Definition\MeasuringDetails\HealthDataType;

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
        
    public function getKey(): string
    {
        return $this->key;
    }

    public function getMeasurementUnits(): array
    {
        return $this->measurementUnits;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function setMeasurementUnits(array $measurementUnits)
    {
        $this->measurementUnits = $measurementUnits;
    }
    
}
