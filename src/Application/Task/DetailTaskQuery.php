<?php

namespace App\Application\Task;

use App\Repository\TaskRepository;

class DetailTaskQuery
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function execute(string $uuid): TaskObject
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $taskObject = new TaskObject();
        $taskObject->setUuid($task->getUuid());
        $taskObject->setAlias($task->getAlias());
        $taskObject->setType($task->getType());
        $taskObject->setStatus($task->getStatus());
        $taskObject->setTitle($task->getTitle());
        $taskObject->setEpic($task->getEpic()->getUuid());
        $taskObject->setCreationUser($task->getCreationUser());
        $taskObject->setCreationDate($task->getCreationDate());

        return $taskObject;
    }

}