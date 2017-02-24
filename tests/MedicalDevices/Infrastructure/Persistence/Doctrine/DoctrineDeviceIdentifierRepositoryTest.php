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

namespace Tests\MedicalDevices\Infrastructure\Persistence\Doctrine;

use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifierRepositoryInterface;
use MedicalDevices\Domain\Model\Device\Identifier\Identifier;
use MedicalDevices\Domain\Model\Device\Identifier\DeviceIdentifier;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineDeviceIdentifierRepository;

/**
 * Description of DoctrineDeviceIdentifierRepositoryTest
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineDeviceIdentifierRepositoryTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $container;
    private $doctrineDeviceIdentifierRepository;

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
     * @group deviceidentifier_repository
     */
    public function implementsDomainInterface()
    {
        $this->assertTrue($this->doctrineDeviceIdentifierRepository instanceof DeviceIdentifierRepositoryInterface);
    }

    /**
     * @test
     * @group deviceidentifier_repository
     */
    public function deviceIdentifierOfIdentifier()
    {
        $identifier = new Identifier('SNO', 'SN123456');
        $deviceIdentifier = $this->doctrineDeviceIdentifierRepository->deviceIdentifierOfIdentifier($identifier);

        $this->assertTrue($deviceIdentifier instanceof DeviceIdentifier);
    }

    /**
     * @test
     * @group deviceidentifier_repository
     */
    public function deviceIdentifiersOfDevice()
    {
        $identifier = new Identifier('SNO', 'SN123456');
        $deviceIdentifier = $this->doctrineDeviceIdentifierRepository->deviceIdentifierOfIdentifier($identifier);
        $deviceId = $deviceIdentifier->device()->id();

        $deviceIdentifiers = $this->doctrineDeviceIdentifierRepository->deviceIdentifiersOfDevice($deviceId);
     
        $this->assertTrue(3 == count($deviceIdentifiers));
        $referenceDeviceIdentifier = current($deviceIdentifiers);
        $this->assertTrue($referenceDeviceIdentifier instanceof DeviceIdentifier);
        
        $this->assertTrue(is_bool($referenceDeviceIdentifier->isReferenceIdentifier()) && DeviceIdentifier::IS_REFERENCE_ID == $referenceDeviceIdentifier->isReferenceIdentifier());
        
        $nextDeviceIdentifier = next($deviceIdentifiers);
        $this->assertTrue(is_bool($referenceDeviceIdentifier->isReferenceIdentifier()) && DeviceIdentifier::IS_NOT_REFERENCE_ID == $nextDeviceIdentifier->isReferenceIdentifier());
    }

    /**
     * @test
     * @group deviceidentifier_repository
     */
     public function referenceDeviceIdentifierOfDevice()
     {
        $identifier = new Identifier('SNO', 'SN123456');
        $deviceIdentifier = $this->doctrineDeviceIdentifierRepository->deviceIdentifierOfIdentifier($identifier);
        $deviceId = $deviceIdentifier->device()->id();

        $referenceDeviceIdentifier = $this->doctrineDeviceIdentifierRepository->referenceDeviceIdentifierOfDevice($deviceId); 
      
        $this->assertTrue($referenceDeviceIdentifier instanceof DeviceIdentifier);
     }        
    
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

}
