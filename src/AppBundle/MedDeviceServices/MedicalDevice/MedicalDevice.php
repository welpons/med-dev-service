<?php

namespace AppBundle\MedDeviceServices\MedicalDevice;

use MedicalDevices\Domain\Model\MedDevice\Model;

class MedicalDevice
{
    /**
     *
     * @var MedicalDevices\Domain\Model\MedDevice\Model
     */
    private $model;
    
    public function getModel(): MedDeviceModel {
        return $this->model;
    }

    public function setModel(Model $model) {
        $this->model = $model;
    }

    public function __construct()
    {
        $this->model = new Model();
    }


}

