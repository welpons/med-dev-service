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

/**
 * Description of ValidationErrors
 *
 * @author Welpons <welpons@gmail.com>
 */
class ValidationErrors
{
    const UNDEFINED_DEVICE_CATEGORY_ID =       '0001';
    const UNDEFINED_DEVICE_MODEL_ID =          '0002';
    const UNDEFINED_DEVICE_TYPE_KEY =          '0003';
    const DEVICE_IDENTIFIER_ALREADY_EXISTS =   '0004'; 
    const UNKNOWN_VALIDATION_ERROR =           '0005';
    const FILTER_INVALID_STRING =              '0006';
    const NOT_FOUND_CATEGORY_ID =              '0007';
    const NOT_FOUND_DEVICE_MODEL_TYPE_KEY =    '0008'; 
    const NOT_FOUND_DEVICE_MODEL_ID =          '0009';
    const UNDEFINED_DEVICE_IDENTIFIER_VALUE =  '0010';
    const UNDEFINED_DEVICE_IDENTIFIER_TYPE =   '0011';
    const UNDEFINED_REPOSITORY =               '0012';
    const INVALID_DEVICE_IDENTIFIER_TYPE =     '0013'; 
    const INVALID_NUMBER_REF_IDENTIFIERS =     '0014';
    const DEVICE_IDENTIFIER_NOT_FOUND =        '0015'; 
}
