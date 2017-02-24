<?php

namespace AppBundle\MedDeviceServices\MedicalDevice\Components;

/**
 * Description of Model
 *
 * @author jenkins
 */
class Model 
{
    /**
     *
     * @var string 
     */
    private $name;
    
    /**
     *
     * @var string 
     */
    private $number;
    
    public function getName(): string 
    {
        return $this->name;
    }

    public function getNumber(): string 
    {
        return $this->number;
    }

    public function setName(string $name) 
    {
        $this->name = $name;
    }

    public function setNumber(string $number) 
    {
        $this->number = $number;
    }

    
}
