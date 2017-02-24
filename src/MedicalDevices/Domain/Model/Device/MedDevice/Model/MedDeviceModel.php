<?php

namespace MedicalDevices\Domain\Model\Device\MedDevice\Model;

/**
 * Description of Model
 *
 * @author jenkins
 */
class MedDeviceModel 
{
    private $id;
    
    /**
     * @var string 
     */
    private $name;
    
    /**
     * @var string 
     */
    private $number;
    
    public function __construct($name, $number)
    {
        $this->name = $name;
        $this->number = $number;
    }

    
    public function getName(): string 
    {
        return $this->name;
    }

    public function getNumber(): string 
    {
        return $this->number;
    }
    
}
