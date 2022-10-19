<?php
namespace App\Domain\Core\Entity;

class Item
{
    private int $id;
    private string $data;
    private string $status;

    private Import $import;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

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
     * Get the value of import
     */ 
    public function getImport()
    {
        return $this->import;
    }

    /**
     * Set the value of import
     *
     * @return  self
     */ 
    public function setImport($import)
    {
        $this->import = $import;

        return $this;
    }
}