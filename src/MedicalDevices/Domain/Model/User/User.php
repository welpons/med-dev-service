<?php

namespace MedicalDevices\Domain\Model\User;

/**
 * Description of User
 *
 * @author jenkins
 */
class User
{
    /**
     * @var UserId 
     */
    private $userId;
    
    public function __construct(UserId $userId)
    {
        $this->setUserId($userId);
    }   
    
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function uiserId()
    {
        return $this->userId;
    }        
}
