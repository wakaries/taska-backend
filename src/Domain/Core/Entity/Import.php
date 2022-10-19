<?php

namespace App\Domain\Core\Entity;

use App\Repository\ImportRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class Import
{
    private ?int $id = null;

    private ?\DateTimeInterface $creationDate = null;

    private Collection $items;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreationDate(): ?\DateTimeInterface {
        return $this->creationDate;
    }

    /**
     * @param \DateTimeInterface|null $creationDate
     */
    public function setCreationDate(?\DateTimeInterface $creationDate): void {
        $this->creationDate = $creationDate;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection {
        return $this->items;
    }

    /**
     * @param Collection $items
     */
    public function setItems(Collection $items): void {
        $this->items = $items;
    }


}
