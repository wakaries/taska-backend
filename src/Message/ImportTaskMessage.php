<?php

namespace App\Message;

final class ImportTaskMessage
{
    private $itemId;

    

    /**
     * Get the value of itemId
     */ 
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set the value of itemId
     *
     * @return  self
     */ 
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }
}
