<?php

namespace AppBundle\Tests\MedDeviceServices\MedicalDevice\Components;

use AppBundle\MedDeviceServices\MedicalDevice\Components\Model;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of ModelTest
 *
 * @author jenkins
 */
class ModelTest extends KernelTestCase
{
    /**
     * @group medical_device
     * @group medical_device_components
     */
    public function testModel()
    {
        $model = new Model();
        $model->setName('BG 03');
        
        $this->assertEquals('BG 03', $model->getName());
    }        
}
