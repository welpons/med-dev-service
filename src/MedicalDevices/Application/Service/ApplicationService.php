<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MedicalDevices\Application\Service;

use MedicalDevices\Configuration\ConfigurationsInterface;
use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Application\Service\Validation\ValidationService;

/**
 * Description of ApplicationService
 *
 * @author jenkins
 */
abstract class ApplicationService
{
    protected $configurations;
    protected $repositories = null;
    protected $validationService;
    
    public function __construct(ConfigurationsInterface $configurations, RepositoryCollection $repositoryCollection)
    {
        $this->configurations = $configurations;
        $this->repositories = $repositoryCollection;
        $this->validationService = new ValidationService($this->configurations, $this->repositories);
    }
}
