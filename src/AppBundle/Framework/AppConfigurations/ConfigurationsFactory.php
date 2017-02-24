<?php



namespace AppBundle\Framework\AppConfigurations;

use MedicalDevices\Configuration\Configurations;
use MedicalDevices\Application\Configuration\AppConfig;
use MedicalDevices\Domain\Configuration\DomainConfig;
use MedicalDevices\Infrastructure\Configuration\InfrastructureConfig;

/**
 * Description of Configuration
 *
 * @author jenkins
 */
class ConfigurationsFactory
{
    public static function getConfigurations()
    {
        $configurations = new Configurations();
        $appConfig = new AppConfig();
        $domainConfig = new DomainConfig();
        $infrastructureConfig = new InfrastructureConfig();
        
        $configurations->set($configurations::CONF_APPLICATION, $appConfig);
        $configurations->set($configurations::CONF_DOMAIN, $domainConfig);
        $configurations->set($configurations::CONF_INFRASTRUCTURE, $infrastructureConfig);
        
        return $configurations;
    }        
}
