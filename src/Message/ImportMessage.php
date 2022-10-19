<?php

namespace App\Message;

final class ImportMessage
{
    private $importId;

    /**
     * Get the value of importId
     */ 
    public function getImportId()
    {
        return $this->importId;
    }

    /**
     * Set the value of importId
     *
     * @return  self
     */ 
    public function setImportId($importId)
    {
        $this->importId = $importId;

        return $this;
    }
}
