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

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of DeviceControllerTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class DevicesControllerTest extends WebTestCase
{

    private $_server;
    private $paramConverter;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->paramConverter = $this->container->get('serialized.param.converter');
        
        $this->_server = array(
            'HTTP_ACCEPT' => 'application/xml',
            'CONTENT_TYPE' => 'text/xml; charset=UTF-8'
        );

    }

    /**
     * @group controller
     * @group controller_device
     */
    public function testAddDevice()
    {
        $client = static::createClient();

        $content = <<<EOT
<?xml version="1.0" encoding="UTF-8" ?> 
<device_request_dto>
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
                <is_reference_identifier>true</is_reference_identifier>
            </identifier>  
        </device_identifiers>    
</device_request_dto>
EOT;

        $crawlerAddDevice = $client->request('POST', '/devices/new', array(), array(), $this->_server, $content);


        echo htmlspecialchars_decode($client->getResponse(), ENT_QUOTES);
        

    }

}
