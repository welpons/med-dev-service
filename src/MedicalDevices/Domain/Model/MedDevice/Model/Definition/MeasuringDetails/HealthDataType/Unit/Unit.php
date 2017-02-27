<?php

namespace MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit;

/**
 * Description of Unit
 *
 * @author jenkins
 */
class Unit
{

    /**
     * @var string 
     */
    private $name;

    /**
     * @var string 
     */
    private $symbol;

    /**
     * @var boolean
     */
    private $default = false;

    public function name(): string
    {
        return $this->name;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function defaultUnit(): bool
    {
        return $this->default;
    }

    public function equals(Unit $unit)
    {
        return $unit->name() === $this->name();
    }

}
