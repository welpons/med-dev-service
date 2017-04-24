<?php

namespace AppBundle\Request;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\Serializer\Serializer;
use JMS\SerializerBundle\Exception\XmlErrorException;

/**
 * This class deserializes request content (xml) into an object
 * 
 * The definition of deserialization is specified using mapping files
 */
class SerializedParamConverter implements ParamConverterInterface
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {       
        $this->serializer = $serializer;          
    }

    public function supports(ParamConverter $configuration)
    {
        if (!$configuration->getClass()) {
            return false;
        }

        return true;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();

        try {
            $object = $this->serializer->deserialize(
                $request->getContent(),
                $class,
                'xml'
            );            
        }        
        catch (XmlErrorException $e) {
            throw new NotFoundHttpException(sprintf('Could not deserialize request content to object of type "%s"', $class));
        }

        // set the object as the request attribute with the given name
        // (this will later be an argument for the action)
        $request->attributes->set($configuration->getName(), $object);
    }
  
}


