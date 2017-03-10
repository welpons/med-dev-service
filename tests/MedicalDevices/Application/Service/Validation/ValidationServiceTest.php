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

namespace Tests\MedicalDevices\Application\Service\Validation;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use MedicalDevices\Application\Service\Validation\ValidationService;
use MedicalDevices\Application\Service\Device\DeviceValidator;
use MedicalDevices\Domain\Model\Device\Device;


/**
 * Description of ValidationServiceTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class ValidationServiceTest extends KernelTestCase
{
    private $container;
    private $init;
    private $repositories;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->init = $this->container->get('init');
        $this->repositories = $this->container->get('repository.collection.provider')->getCollection();

    }    
    
    /**
     * @test
     * @group application_service_validation_service
     */
    public function instantiateValidationService()
    {
        $service = new ValidationService($this->init, $this->repositories);
        $this->assertTrue($service instanceof ValidationService);
    }        
    
    /**
     * @test
     * @group application_service_validation_service
     */
    public function createValidator()
    {
        $service = new ValidationService($this->init, $this->repositories);
        
        $reflectionClass = new \ReflectionClass($service);
        $reflectionMethod = $reflectionClass->getMethod('createValidator');
        $reflectionMethod->setAccessible(true);       
        
        $validator = $reflectionMethod->invokeArgs($service, array(Device::class));
        $this->assertTrue($validator instanceof DeviceValidator);        
    }        
    
    /**
     * @test
     * @group application_service_validation_service
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Validation service. Class not found: WrongClass
     */
    public function createValidatorWrongClass()
    {
        $service = new ValidationService($this->init, $this->repositories);
        
        $reflectionClass = new \ReflectionClass($service);
        $reflectionMethod = $reflectionClass->getMethod('createValidator');
        $reflectionMethod->setAccessible(true);       
        
        $validator = $reflectionMethod->invokeArgs($service, ['WrongClass']);      
    }    
    
    /**
     * @test
     * @group application_service_validation_service
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Validation service. Validator class not found: Tests\MedicalDevices\Application\Service\Validation\NotFoundValidator
     */
    public function createValidatorClassValidatorClasDoesNotExist()
    {
        $this->init->setParameter('application.validators.stdClass', "Tests\MedicalDevices\Application\Service\Validation\NotFoundValidator");
        $service = new ValidationService($this->init, $this->repositories);
        
        $reflectionClass = new \ReflectionClass($service);
        $reflectionMethod = $reflectionClass->getMethod('createValidator');
        $reflectionMethod->setAccessible(true);       
        
        $validator = $reflectionMethod->invokeArgs($service, [get_class(new \stdClass())]);      
    }       
    
    /**
     * @test
     * @group application_service_validation_service
     * @expectedException InvalidArgumentException
     */
    public function createValidatorClassWithNoValidator()
    {
        $this->init->setParameter('application.validators.InvalidValidator', "Tests\MedicalDevices\Application\Service\Validation\InvalidValidator");
        $service = new ValidationService($this->init, $this->repositories);
        
        $reflectionClass = new \ReflectionClass($service);
        $reflectionMethod = $reflectionClass->getMethod('createValidator');
        $reflectionMethod->setAccessible(true);       
        
        $validator = $reflectionMethod->invokeArgs($service, [get_class(new InvalidValidator())]);      
    }     
    
    
}
