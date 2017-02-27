<?php

namespace Tests\MedicalDevicesBundle\Framework;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\MedDevice\Model\ModelDetails\ModelDetails;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel;
use MedicalDevices\Domain\Model\MedDevice\Model\Definition\Definition;
use MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\MeasuringDetails;
use MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit\Unit;
use MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\HealthDataType;

class SerializerTest extends KernelTestCase
{

    private $serializer;
    private $metadataDir;
    private $init;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->serializer = $this->container->get('framework.serializer');
        
        $this->metadataDir = $this->container->get('init')->getParameter('infrastructure.jms_serializer_mapping_dir');
    }

    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_medicaldevicemodel
     */
    public function testConstructor()
    {

        $data = <<<EOF
<medDeviceModel>             
        <model_details>
            <name>3 Series Upper Arm Blood Pressure Monitor</name>
            <model_number>073796271046</model_number>
            <manufacturer>OMRON</manufacturer>                
        </model_details>
        <definition>        
            <measuring_details>        
                <health_data_types>
                        <health_data_type>
                            <key>weight</key>
                            <measurement_units>
                                <unit default="true">
                                    <name>kilogram</name>
                                    <symbol>kg</symbol>
                                </unit>
                                <unit>
                                    <name>pound</name>
                                    <symbol>lb</symbol>
                                </unit>
                            </measurement_units>
                        </health_data_type>
                        <health_data_type>
                            <key>bmi</key>
                            <measurement_units>
                                <unit>
                                    <name>bmi</name>
                                    <symbol>kg/m2</symbol>
                                </unit>
                            </measurement_units>
                        </health_data_type>                
                </health_data_types> 
            </measuring_details>    
        </definition>        
</medDeviceModel>
EOF;




        $medDeviceModel = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel');
        $this->assertTrue($medDeviceModel instanceof MedDeviceModel);
        $this->assertTrue($medDeviceModel->definition() instanceof Definition);
        $this->assertTrue($medDeviceModel->modelDetails() instanceof ModelDetails);
    }

    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_definition
     */
    public function testDefinition()
    {

        $data = <<<EOF
        <definition>        
            <measuring_details>        
                <health_data_types>
                        <health_data_type>
                            <key>weight</key>
                            <measurement_units>
                                <unit default="true">
                                    <name>kilogram</name>
                                    <symbol>kg</symbol>
                                </unit>
                                <unit>
                                    <name>pound</name>
                                    <symbol>lb</symbol>
                                </unit>
                            </measurement_units>
                        </health_data_type>
                        <health_data_type>
                            <key>bmi</key>
                            <measurement_units>
                                <unit>
                                    <name>bmi</name>
                                    <symbol>kg/m2</symbol>
                                </unit>
                            </measurement_units>
                        </health_data_type>                
                </health_data_types> 
            </measuring_details>    
        </definition>         
EOF;

        $definition = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Definition\Definition');
        $this->assertTrue($definition instanceof Definition);
        $this->assertTrue($definition->measuringDetails() instanceof MeasuringDetails);
    }    
    
    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_measuringdetails
     */
    public function testMeasuringDetails()
    {

        $data = <<<EOF
        <measuring_details>        
            <health_data_types>
                    <health_data_type>
                        <key>weight</key>
                        <measurement_units>
                            <unit default="true">
                                <name>kilogram</name>
                                <symbol>kg</symbol>
                            </unit>
                            <unit>
                                <name>pound</name>
                                <symbol>lb</symbol>
                            </unit>
                        </measurement_units>
                    </health_data_type>
                    <health_data_type>
                        <key>bmi</key>
                        <measurement_units>
                            <unit>
                                <name>bmi</name>
                                <symbol>kg/m2</symbol>
                            </unit>
                        </measurement_units>
                    </health_data_type>                
            </health_data_types> 
        </measuring_details>    
EOF;




        $measuringDetails = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\MeasuringDetails');
        $this->assertTrue($measuringDetails instanceof MeasuringDetails);
        $this->assertTrue(is_array($measuringDetails->healthDataTypes()));
    }    
    
    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_model
     */
    public function testModel()
    {

        $data = <<<EOF
        <modelDetails>
            <name>3 Series Upper Arm Blood Pressure Monitor</name>
            <model_number>073796271046</model_number>
            <manufacturer>OMRON</manufacturer>  
        </modelDetails>
EOF;

        $medicalDevice = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\ModelDetails\ModelDetails');
        $this->assertTrue($medicalDevice instanceof ModelDetails);
        $this->assertEquals("3 Series Upper Arm Blood Pressure Monitor", $medicalDevice->name());
    }
    
    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_unit
     */
    public function testUnitDefaultTrue()
    {

        $data = <<<EOF
        <unit default="true">
            <name>kilogram</name>
            <symbol>kg</symbol>
        </unit>
EOF;

        $unit = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit\Unit');
        $this->assertTrue($unit instanceof Unit);
        $this->assertEquals('kg', $unit->symbol());
        $this->assertTrue($unit->defaultUnit());
    }
    
    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_unit
     */
    public function testUnitDefaultFalse()
    {

        $data = <<<EOF
                        <unit default="false">
                            <name>kilogram</name>
                            <symbol>kg</symbol>
                        </unit>
EOF;

        $unit = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\Unit\Unit');
        $this->assertFalse($unit->defaultUnit());
    }    

    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_hdt
     */
    public function testHealthDataType()
    {

        $data = <<<EOF
                <healthDataType>
                    <key>weight</key>
                    <measurement_units>
                        <unit default="true">
                            <name>kilogram</name>
                            <symbol>kg</symbol>
                        </unit>
                        <unit>
                            <name>pound</name>
                            <symbol>lb&lt;sup&gt;2&lt;/sup&gt;</symbol>
                        </unit>
                    </measurement_units>
                </healthDataType>
EOF;

        $healthDataType = $this->serializer->setMetadataDir($this->metadataDir)->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Definition\MeasuringDetails\HealthDataType\HealthDataType');
        $this->assertTrue($healthDataType instanceof HealthDataType);
        $this->assertEquals('weight', $healthDataType->key());
        $this->assertTrue(is_array($healthDataType->measurementUnits()));
    }        
    
}
