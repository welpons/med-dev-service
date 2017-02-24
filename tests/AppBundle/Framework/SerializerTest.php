<?php

namespace Tests\AppBundle\Framework;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SerializerTest extends KernelTestCase
{

    private $serializer;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->serializer = $this->container->get('framework.serializer');
    }

    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_medicaldevice
     */
    public function testConstructor()
    {

        $data = <<<EOF
<medDevice>
        <type>Scale</type>       
        <category>Personal Healthcare Device</category>                  
        <model>
            <name>Gluco</name>
            <id>HU1234</id>    
            <manufacturer>Omron</manufacturer>                
        </model>
        <healthdatatypes>
                <healthDataType>
                    <key>weight</key>
                    <measurementUnits>
                        <unit default="true">
                            <name>kilogram</name>
                            <symbol>kg</symbol>
                        </unit>
                        <unit>
                            <name>pound</name>
                            <symbol>lb</symbol>
                        </unit>
                    </measurementUnits>
                </healthDataType>
                <healthdatatype>
                    <key>bmi</key>
                    <measurementUnits>
                        <unit>
                            <name>bmi</name>
                            <symbol>kg/m2</symbol>
                        </unit>
                    </measurementUnits>
                </healthdatatype>                
        </healthdatatypes>                    
</medDevice>
EOF;




        $medicalDevice = $this->serializer->setMetadataDir('/home/jenkins/med-device-services/src/AppBundle/Resources/config/serializer/')->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\MedDevice');
        print_r($medicalDevice);
    }

    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_model
     */
    public function testModel()
    {

        $data = <<<EOF
        <model>
            <name>Gluco</name>
            <number>HU1234</number>
        </model>
EOF;

        $medicalDevice = $this->serializer->setMetadataDir('/home/jenkins/med-device-services/src/AppBundle/Resources/config/serializer/')->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Model');
        print_r($medicalDevice);
    }

    /**
     * @group framework
     * @group framework_normalizer
     * @group framework_normalizer_defmetadir
     */    
    public function testDefMetaDir()
    {
        $data = <<<EOF
        <model>
            <name>Gluco</name>
            <number>HU1234</number>
        </model>
EOF;

        $medicalDevice = $this->serializer->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\Model\Model');
        print_r($medicalDevice);        
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

        $medicalDevice = $this->serializer->setMetadataDir('/home/jenkins/med-device-services/src/AppBundle/Resources/config/serializer/')->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\MeasuringDetails\HealthDataType\Unit\Unit');
        print_r($medicalDevice);
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

        $medicalDevice = $this->serializer->setMetadataDir('/home/jenkins/med-device-services/src/AppBundle/Resources/config/serializer/')->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\MeasuringDetails\HealthDataType\Unit\Unit');
        print_r($medicalDevice);
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

        $medicalDevice = $this->serializer->setMetadataDir('/home/jenkins/med-device-services/src/AppBundle/Resources/config/serializer/')->deserialize($data, 'MedicalDevices\Domain\Model\MedDevice\MeasuringDetails\HealthDataType\HealthDataType');
        print_r($medicalDevice);
    }        
    
}
