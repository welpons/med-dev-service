<?php

namespace MedicalDevices\Domain\Model\MedDevice\Model;

use MedicalDevices\Infrastructure\Persistence\RepositoryInterface;
use MedicalDevices\Domain\Model\Device\Model\Model;
use MedicalDevices\Domain\Model\MedDevice\Model\MedDeviceModel;
/**
 * Description of MedDeviceModelRepository
 *
 * @author jenkins
 */
interface MedDeviceModelRepositoryInterface extends RepositoryInterface
{    
    public function medDeviceModelOfId(Model $model) : MedDeviceModel;
}
