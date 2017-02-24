<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\MedDeviceServices;

/**
 *
 * @author jenkins
 */
interface ServicesInterface
{
    /**
     * @param string $serviceNamespace
     * @return mixed
     */
    public function get(string $serviceNamespace);
    
    /**
     * 
     * @param mixed $key
     * @return mixed Description
     */
    public function getParameter($key);
}
