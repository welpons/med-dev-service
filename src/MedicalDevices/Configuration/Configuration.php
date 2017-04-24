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

namespace MedicalDevices\Configuration;

/**
 * Contains all configurations. Configuration parameters are grouped in "groups".
 * They 
 *
 * @author Welpons <welpons@gmail.com>
 */
class Configuration implements ConfigurationInterface
{

    const CHECK_ONLY = true;
    const SEPARATOR = '.';

    /**
     * Array of parameter groups
     * 
     * @var array 
     */
    public static $groups = ['application', 'model', 'infrastructure'];

    /**
     * @var array 
     */
    private $configParams = array();

    /**
     * Multidimensional array. 
     * [
     *      'application' => [ ... ],
     * ]
     * 
     * @param array $configParams
     */
    public function __construct(array $configParams)
    {
        $this->configParams = $configParams;
    }

    public function getParameter($paramName)
    {
        return $this->selectElement($paramName);
    }

    public function hasParameter($paramName): bool
    {
        return $this->selectElement($paramName, self::CHECK_ONLY);
    }

    public function setParameter($paramName, $value)
    {
        $this->assignElementByPath($this->configParams, $paramName, $value);
    }

    private function assignElementByPath(array &$configParams, string $paramName, $value, string $separator = self::SEPARATOR)
    {
        $keys = explode($separator, $paramName);

        foreach ($keys as $key) {
            $configParams = &$configParams[$key];
        }

        $configParams = $value;
    }

    /**
     * 
     * 
     * @param string  $paramName
     * @param boolean $checkOnly
     * @return boolean|mixed
     * @throws UndefinedParameterException
     */
    private function selectElement($paramName, $checkOnly = false)
    {
        $keys = explode(self::SEPARATOR, $paramName);
        $param = $this->configParams;

        foreach ($keys as $key) {
            if (!isset($param[$key])) {
                if ($checkOnly) {
                    return false;
                }

                throw new UndefinedParameterException(sprintf('Undefined parameter: "%s"', $paramName));
            }
            $param = $param[$key];
        }

        return $checkOnly ? true : $param;
    }

}
