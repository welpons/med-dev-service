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

namespace MedicalDevices\Application\Service;

use MedicalDevices\Configuration\ConfigurationInterface;
use MedicalDevices\Infrastructure\Persistence\RepositoriesProvider;
use MedicalDevices\Application\Service\Validation\ValidationService;

/**
 * Description of ApplicationService
 *
 * @author Welpons <welpons@gmail.com>
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
