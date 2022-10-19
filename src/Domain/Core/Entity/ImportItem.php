<?php

namespace App\Domain\Core\Entity;

use App\Repository\ImportRepository;
use Doctrine\ORM\Mapping as ORM;

class ImportItem
{
    private ?int $id = null;

    private ?string $data = null;

    private ?Import $import = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string {
        return $this->data;
    }

    /**
     * @param string|null $data
     */
    public function setData(?string $data): void {
        $this->data = $data;
    }

    /**
     * @return Import|null
     */
    public function getImport(): ?Import {
        return $this->import;
    }

    /**
     * @param Import|null $import
     */
    public function setImport(?Import $import): void {
        $this->import = $import;
    }


}
