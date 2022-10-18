<?php

namespace App\Application\Task;

use App\Entity\Epic;
use Symfony\Component\Validator\Constraints as Assert;

class TaskObject
{
    #[Assert\NotBlank]
    private ?string $uuid = null;
    #[Assert\NotBlank]    
    private ?string $alias = null;
    #[Assert\NotBlank]
    #[App\Validator\Entity(Epic::class)]
    private ?string $epic = null;
    #[Assert\NotBlank]
    private ?\DateTimeInterface $creationDate = null;
    #[Assert\NotBlank]
    private ?string $title = null;
    private ?string $description = null;
    #[Assert\NotBlank]
    #[Assert\Choice(callback: [Task::class, 'getTypesKeys'])]
    private ?string $type = null;
    #[Assert\NotBlank]
    private ?string $creationUser = null;
    private ?string $currentUser = null;



    /**
     * Get the value of uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @return  self
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get the value of alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set the value of alias
     *
     * @return  self
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get the value of epic
     */
    public function getEpic()
    {
        return $this->epic;
    }

    /**
     * Set the value of epic
     *
     * @return  self
     */
    public function setEpic($epic)
    {
        $this->epic = $epic;

        return $this;
    }

    /**
     * Get the value of creationDate
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of creationUser
     */ 
    public function getCreationUser()
    {
        return $this->creationUser;
    }

    /**
     * Set the value of creationUser
     *
     * @return  self
     */ 
    public function setCreationUser($creationUser)
    {
        $this->creationUser = $creationUser;

        return $this;
    }

    /**
     * Get the value of currentUser
     */ 
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * Set the value of currentUser
     *
     * @return  self
     */ 
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;

        return $this;
    }
}
