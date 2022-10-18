<?php

namespace App\Application\Epic;

use App\Domain\Core\Entity\Epic;
use App\Repository\EpicRepository;

class ListEpicsQuery {

    public function __construct(private EpicRepository $epicRepository) {}

    /**
     * @return ListEpicsQueryOutput[]
     */
    public function execute(): array
    {
        $result = [];
        $epics = $this->epicRepository->findAll();
        foreach ($epics as $epic) {
            $result[] = $this->mapEpicOutput($epic);
        }

        return $result;
    }

    private function mapEpicOutput(Epic $epic)
    {
        $result = new ListEpicsQueryOutput();
        $result->setUuid($epic->getUuid());
        $result->setTitle($epic->getTitle());

        return $result;
    }
}
