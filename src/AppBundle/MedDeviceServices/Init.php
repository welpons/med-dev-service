<?php

namespace AppBundle\MedDeviceServices;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Init
 *
 * @author jenkins
 */
class Init {

    private $container;
    
    public function __construct(ContainerInterface $container) {
        
        $this->container = $container;

        $kernel = $this->_container->get('kernel');
    }

}
