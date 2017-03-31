<?php

/*
 * Copyright (C) 2017 Welpons <welpons@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tests\AppBundle\Request;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use MedicalDevices\Application\DTO\Device\DeviceRequestDTO;

/**
 * Description of SerializedParamConverterTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class SerializedParamConverterTest extends KernelTestCase
{
    private $container;
    private $serializedParamConverter;
    
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->serializedParamConverter = $this->container->get('serialized.param.converter');
    } 
    
    /**
     * @test
     * @group appbundle_request
     * @group appbundle_request_serializedparamconverter
     */
    public function apply()
    {
        $content = <<<EOT
<?xml version="1.0" encoding="UTF-8" ?> 
<newDevice xmlns="urn:med.dev.rest.ws">
	<category_id>med</category_id>
	<model>
            <id>FORA_D40</id>
            <type>
                <key>GLUCO</key>
                <name></name>
            </type>    
        </model>
        <device_identifiers>
            <identifier>
                <type>SNO</type>
                <value>SNO00896E34</value>
                <is_reference_identifier/>
            </identifier>  
        </device_identifiers>    
</newDevice>
EOT;
        
        $request = Request::create('/devices/new', 'POST', [], [], [], [], $content);
        $paramConverter = new ParamConverter(['class' => 'MedicalDevices\Application\DTO\Device\DeviceRequestDTO', 'name' => 'newDevice', 'converter' => 'param_converter']);
        $this->serializedParamConverter->apply($request, $paramConverter);
        $this->assertTrue($request->attributes->get('newDevice') instanceof DeviceRequestDTO);
    }        
}
