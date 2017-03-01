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

namespace Tests\MedicalDevices\Infrastructure\Persistence\JMSSerializer;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Infrastructure\Persistence\JMSSerializer\JMSSerializerMedDeviceModelRepository;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\Device\Model\Type\Type;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModelRepositoryInterface;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel;

/**
 * Description of JMSSerializerMedDeviceModelRepositoryTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class JMSSerializerMedDeviceModelRepositoryTest extends KernelTestCase
{
    private $container;
    private $init;
    private $path;
    private $serializer;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->serializer = $this->container->get('ext.services.serializer');
        $this->init = $this->container->get('init');
        $this->path = dirname(__FILE__) . '/';
    }
    
    /**
     * @test 
     * @group infrastructure_persistence_jmsserializer_meddevicemodel_repo
     */
    public function testRepositoryImplementsInterface()
    {
        $repository = new JMSSerializerMedDeviceModelRepository($this->serializer, $this->path);
        $this->assertTrue($repository instanceof MedDeviceModelRepositoryInterface);
    }        
    
    /**
     * @test 
     * @group infrastructure_persistence_jmsserializer_meddevicemodel_repo
     * @expectedException MedicalDevices\Infrastructure\Persistence\JMSSerializer\MedDeviceModelDirNotExistException
     */
    public function medDeviceModelDirectoryDoesNotExist()
    {
        $repository = new JMSSerializerMedDeviceModelRepository($this->serializer, 'wrong_path');
        $this->assertTrue($repository instanceof MedDeviceModelRepositoryInterface);
    }      
    
    /**
     * @test 
     * @group infrastructure_persistence_jmsserializer_meddevicemodel_repo
     */
    public function applicationDirectory()
    {       
        $repository = new JMSSerializerMedDeviceModelRepository($this->serializer, $this->init->getParameter('infrastructure.jms_serializer_mapping_dir'));
        $this->assertTrue($repository instanceof MedDeviceModelRepositoryInterface);
    }      
    
    /**
     * @test 
     * @group infrastructure_persistence_jmsserializer_meddevicemodel_repo
     */
    public function medDeviceModelOfId()
    {
        $repository = new JMSSerializerMedDeviceModelRepository($this->serializer, $this->path);
        $medDeviceModel = $repository->medDeviceModelOfId(new Model('Entra_MyGlucoHealth_MGH-1', new Type('GLUCO', 'glucometer')));
        $this->assertTrue($medDeviceModel instanceof MedDeviceModel);
        $this->assertEquals('Entra', $medDeviceModel->modelDetails()->manufacturer());
        $healthDataTypes = $medDeviceModel->definition()->measuringDetails()->healthDataTypes();
        $this->assertTrue(is_array($healthDataTypes) && 5 == count($healthDataTypes));
    }       
}
