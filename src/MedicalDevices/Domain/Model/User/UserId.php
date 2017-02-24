<?php

namespace MedicalDevices\Domain\Model\User;



class UserId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        // validation
        
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param UserId $userId
     *
     * @return bool
     */
    public function equals(UserId $userId)
    {
        return $this->id() === $userId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}