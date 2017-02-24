<?php

namespace MedicalDevices\Application\Service;

/**
 * Description of ApplicationService
 *
 * @author jenkins
 */
interface ApplicationServiceCommand
{
    /**
     * @param $request
     * @return mixed
     */
    public function execute($request = null);
}
