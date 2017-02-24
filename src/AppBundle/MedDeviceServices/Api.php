<?php

namespace AppBundle\MedDeviceServices;

use AppBundle\MedDeviceServices\Init;
use AppBundle\MedDeviceServices\ServicesInterface;

/**
 * Description of Api
 *
 * @author jenkins
 */
abstract class Api
{

    protected $init;
    protected $services;
    protected $modules;

    /**
     * array of different objects not defined as services and accessible from differents application apis 
     * through public properties.
     * 
     * @var array 
     */
    protected $_instances = array();

    public function __construct(Init $init, ServicesInterface $services)
    {
        $this->init = $init;
        $this->services = $services;
        $this->modules = $services->getParameter('modules.classes');
        $this->services->set('metadatadir', dirname(__FILE__ . $this->services->getParameter('serializer.metadata.dir')));
    }

    /**
     * Allows to access to different program sections as: logbook, events and goals
     * 
     * @param string $property
     * @return AppBundle\Modules\UserApi
     */
    public function __get($property)
    {
        if (in_array($property, array_keys($this->modules))) {
            if (!isset($this->_instances[$property])) {
                $class = 'AppBundle\\MedDeviceServices\\' . $this->modules[$property];
                $this->_instances[$property] = new $class($this->init, $this->services);
            }
            
            return $this->_instances[$property];
        }
    }

}
