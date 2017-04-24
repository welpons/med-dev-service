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

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use MedicalDevices\Application\Service\Device\AddDeviceWithReferenceIdentifierService;
use MedicalDevices\Application\DTO\Device\DeviceRequestDTO;

/**
 * This controller has all services related with system devices
 *
 * @author Welpons <welpons@gmail.com>
 */
class DevicesController extends FOSRestController
{
    /**
     * Adds a new device with at leat one device identifier
     * 
     * @param  MedicalDevices\Application\DTO\Device\DeviceRequestDTO $deviceRequestDTO
     * @return type
     * 
     * @Post("/devices/new")
     * @Rest\View
     * @ParamConverter("newDevice", class="MedicalDevices\Application\DTO\Device\DeviceRequestDTO", converter="param_converter")
     */
    public function newDevicesAction(DeviceRequestDTO $deviceRequestDTO)
    {             
        $addDeviceWithIdentifiersService = new AddDeviceWithReferenceIdentifierService($this->get('init'), $this->get('repository.collection.provider')); 
        
        try { 
            $response = $addDeviceWithIdentifiersService->execute($this->get('ext.services.validation.error.handler'), $deviceRequestDTO); 
            
        } catch (\Exception $e) { 
            return new JsonResponse($this->get('ext.services.validation.error.handler')->getErrors(), 400);
        } 
        
        return new JsonResponse(array('message' => 'Ok'), 200); 
    } 
}
