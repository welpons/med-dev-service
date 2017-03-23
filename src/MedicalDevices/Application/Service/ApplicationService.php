<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MedicalDevices\Application\Service;

use MedicalDevices\Configuration\ConfigurationInterface;
use MedicalDevices\Infrastructure\Persistence\RepositoriesProvider;
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
    
    public function __construct(ConfigurationInterface $configurations, RepositoriesProvider $repositoriesProvider)
    {
        $this->configurations = $configurations;
        $this->repositories = $repositoriesProvider->getCollection();
        $this->validationService = new ValidationService($this->configurations, $this->repositories);
    }
}
