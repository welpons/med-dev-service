<?php

namespace MedicalDevices\Domain\Model\Device\Model;

use MedicalDevices\Domain\Model\Device\Model\Type\Type;

/**
 * Description of Model
 *
 * @author jenkins
 */
class Model 
{
    private $id;
    
    /**
     *
     * @var Type 
     */
    protected $type;
    
    public function __construct($id, Type $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function id()
    {
        return $this->id;
    }        

    public function type()
    {
        return $this->type;
    }        
}
