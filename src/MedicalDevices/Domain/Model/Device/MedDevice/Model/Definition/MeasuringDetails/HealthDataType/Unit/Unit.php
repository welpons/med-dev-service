<?php

namespace MedicalDevices\Domain\Model\Device\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getDefault(): bool
    {
        return $this->default;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
    }

    public function setDefault(bool $default)
    {
        $this->default = $default;
    }

    public function equals(Unit $unit)
    {
        return $unit->name() === $this->name();
    }

}
