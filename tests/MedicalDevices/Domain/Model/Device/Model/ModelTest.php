<?php

namespace Tests\MedicalDevices\Domain\Model\Device\Model;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel;

class ModelTest extends KernelTestCase
{
    
    public function setUp()
    {
        self::bootKernel();


    }
    
    /**
     * @group model_domain_meddevice_model
     */
    public function testModel()
    {
        $model = new MedDeviceModel();

        $this->assertTrue($model instanceof MedDeviceModel);
    }      
    
    
}
