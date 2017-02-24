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

namespace MedicalDevicesBundle\Framework;

use Symfony\Component\DependencyInjection\ContainerInterface;
use MedicalDevices\Configuration\Configuration;

/**
 * Description of AppConfigProvider
 *
 * @author Welpons <welpons@gmail.com>
 */
class ConfigFactory
{

    protected $config;
    

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container->getParameterBag()->all();
    }

    public function createConfiguration()
    {
        $parameters = array_intersect_key($this->config['med.devices.services.init'], array_flip(Configuration::$groups));

        return new Configuration($parameters);
    }

}
