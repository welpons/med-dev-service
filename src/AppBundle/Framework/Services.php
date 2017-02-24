<?php

namespace AppBundle\Framework;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Settings
 *
 * @author jenkins
 */
class Services implements ServicesInterface
{

    private $container;
    
    public function __construct(ContainerInterface $container) {
        
        $this->container = $container;
    }

    public function get(string $serviceNamespace)
    {
        return $this->container->get($serviceNamespace);
    }
    
    public function setParameter($name, $value)
    {
        $this->container->setParameter($name, $value);
    }        

    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

}
