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

namespace MedicalDevices\Application\Service\Validation;

use MedicalDevices\Infrastructure\Persistence\RepositoryCollection;
use MedicalDevices\Application\Service\DTOInterface;
use MedicalDevices\Application\Service\Validation\ValidatorHandlerInterface;
use MedicalDevices\Configuration\ConfigurationInterface;

/**
 * Description of Validator
 *
 * @author Welpons <welpons@gmail.com>
 */
abstract class Validator
{

    const FILTER_TYPE_URL = 'url';
    const FILTER_TYPE_INT = 'int';
    const FILTER_TYPE_FLOAT = 'float';
    const FILTER_TYPE_STRING = 'string';
    const FILTER_TYPE_EMAIL = 'email';

    protected $repositories = null;
    
    protected $configurations = null;
    
    public function __construct(ConfigurationInterface $configurations)
    {
        $this->configurations = $configurations;
    }

    abstract public function validate(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto);

    abstract public function withRepositories(): bool;

    public function addRepositories(RepositoryCollection $repositories)
    {
        if (!$this->withRepositories()) {
            throw new ValidatorDoesNotRequireRepositoriesException('This validator does not require repositories to validate data.');
        }
        
        $this->repositories = $repositories;
    }

    public function sanatize($items)
    {
        foreach ($items as $key => $val) {
            if (array_search($key, $this->sanatations) === false && !array_key_exists($key, $this->sanatations)) {
                continue;
            }    
            $items[$key] = self::sanatizeItem($val, $this->validations[$key]);
        }

        return $items;
    }

    /**
     *
     * Sanatize a single var according to $type.
     * Allows for static calling to allow simple sanatization
     * 
     */
    public static function sanatizeItem(string $type, $var)
    {
        $flags = null;

        switch ($type) {
            case self::FILTER_TYPE_URL :
                $filter = FILTER_SANITIZE_URL;
                break;
            case self::FILTER_TYPE_INT :
                $filter = FILTER_SANITIZE_NUMBER_INT;
                break;
            case self::FILTER_TYPE_FLOAT :
                $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                $flags = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
                break;
            case self::FILTER_TYPE_EMAIL :
                $var = substr($var, 0, 254);
                $filter = FILTER_SANITIZE_EMAIL;
                break;
            case self::FILTER_TYPE_STRING :
            default:
                $filter = FILTER_SANITIZE_STRING;
                $flags = FILTER_FLAG_NO_ENCODE_QUOTES;
                break;
        }

        $output = filter_var($var, $filter, $flags);

        return $output;
    }

}
