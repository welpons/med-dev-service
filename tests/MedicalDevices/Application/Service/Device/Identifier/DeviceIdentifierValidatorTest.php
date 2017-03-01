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

namespace Tests\MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierValidator;

use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierValidator;
use MedicalDevices\Application\Service\Device\Identifier\DeviceIdentifierDTO;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceIdentifierRepository;
use MedicalDevices\Application\Service\Validation\ValidationErrors;

use Tests\MedicalDevices\Infrastructure\Persistence\Doctrine\LoadDeviceIdentifierData;

/**
 * Description of DeviceIdentifierValidator
 *
 * @author Welpons <welpons@gmail.com>
 */
class DeviceIdentifierValidatorTest extends KernelTestCase
{
    private $em;
    private $container;
    private $doctrineDeviceIdentifierRepository;
    private $validationErrorHandler;
    private $repositories;
    private $validator;
    private $configurations;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $application = new App(static::$kernel);
        $this->container = static::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
        $this->doctrineDeviceIdentifierRepository = new DoctrineDeviceIdentifierRepository($this->em);
        $this->validationErrorHandler = $this->container->get('ext.services.validation.error.handler');
        $this->repositories = $this->container->get('repository.collection.provider');
        $this->configurations = $this->container->get('init');
        
        $this->validator = new DeviceIdentifierValidator($this->configurations);
        $this->validator->addRepositories($this->repositories->getCollection());     
        

        $commandDrop = $application->find('doctrine:schema:drop');
        $commandTesterDrop = new CommandTester($commandDrop);
        $commandTesterDrop->execute(array('command' => $commandDrop->getName(), '--env' => 'test', '--force' => true));

        $commandCreate = $application->find('doctrine:schema:create');
        $commandTesterCreate = new CommandTester($commandCreate);
        $commandTesterCreate->execute(array('command' => $commandCreate->getName(), '--env' => 'test'));

        $fixture = new LoadDeviceIdentifierData();
        $fixture->load($this->em);
    }   
    
    
    /**
     * @test
     * @group application_service_device_identifier_validator
     */
    public function dtoWithExistingDeviceIdentifier()
    {
        $dto = new DeviceIdentifierDTO('SNO', 'SN123456');
        $this->validator->validate($this->validationErrorHandler, $dto);
     
        $this->assertFalse($this->validationErrorHandler->hasErrors()); 
    }   
    
    /**
     * @test
     * @group application_service_device_identifier_validator
     */
    public function dtoEmptyType()
    {
        $dto = new DeviceIdentifierDTO('', 'SN123456');
        $this->validator->validate($this->validationErrorHandler, $dto);
        
        $this->assertTrue($this->validationErrorHandler->hasErrors());
        $errorCodes = array_column($this->validationErrorHandler->getErrors(), 'code');       
        $this->assertTrue(2 == count($errorCodes) && in_array(ValidationErrors::UNDEFINED_DEVICE_IDENTIFIER_TYPE, $errorCodes));
    }     
    
    /**
     * @test
     * @group application_service_device_identifier_validator1
     */
    public function dtoWrongType()
    {
        $dto = new DeviceIdentifierDTO('WRONG_TYPE', 'SN123456');
        $this->validator->validate($this->validationErrorHandler, $dto);
       
        $this->assertTrue($this->validationErrorHandler->hasErrors());
        $errorCodes = array_column($this->validationErrorHandler->getErrors(), 'code');
        $this->assertTrue(1 == count($errorCodes) && in_array(ValidationErrors::INVALID_DEVICE_IDENTIFIER_TYPE, $errorCodes));
    }        
}
