<?php

namespace MedicalDevices\Application\Service;

use MedicalDevices\Application\Service\ValidatorHandlerInterface;
use MedicalDevices\Application\Service\DTOInterface;

/**
 * Description of ApplicationService
 *
 * @author jenkins
 */
interface ApplicationServiceCommandInterface
{
    /**
     * @param ValidatorHandlerInterface $validatorHandler
     * @param DTOInterface $dto
     * @return mixed
     */
    public function execute(ValidatorHandlerInterface $validatorHandler, DTOInterface $dto = null);
}
