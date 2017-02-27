<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails;

/**
 * Description of MeasuringDetails
 *
 * @author jenkins
 */
class MeasuringDetails
{
    private $healthDataTypes;
    
    public function __construct(array $healthDataTypes)
    {
        $this->healthDataTypes = $healthDataTypes;
    }

    public function healthDataTypes()
    {
        return $this->healthDataTypes;
    }


}
