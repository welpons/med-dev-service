<?php

namespace Tests\MedicalDevices\Domain\Model\Device\Model;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;

class ModelTest extends KernelTestCase
{
    
    public function setUp()
    {
        self::bootKernel();


    }
    
    /**
     * @group model_domain_device_model
     */
    public function testModel()
    {
        $model = new Model('FORA_D40', new Type('GLUCO'));

        $this->assertTrue($model instanceof Model);
    }      
    
    
}
