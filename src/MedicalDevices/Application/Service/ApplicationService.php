<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MedicalDevices\Application\Service;

use MedicalDevices\Configuration\ConfigurationsInterface;
use MedicalDevices\Application\Service\ValidatorHandlerInterface;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;

/**
 * Description of ApplicationService
 *
 * @author jenkins
 */
abstract class ApplicationService
{
    protected $configurations;
    protected $validatorHandler;
    protected $repositories = null;
    
    public function __construct(ConfigurationsInterface $configurations, ValidatorHandlerInterface $validatorHandler, RepositoryCollection $repositoryCollection)
    {
        $this->configurations = $configurations;
        $this->validatorHandler = $validatorHandler;
        $this->repositories = $repositoryCollection;
    }
}
