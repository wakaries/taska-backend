<?php

namespace App\Application\Task;

use App\Domain\Core\Entity\Task;
use App\Domain\Task\Service\Task\TaskService;

class ListTasksQuery
{
    public function __construct(private TaskService $taskService) {
    }

    /**
     * @return ListTasksQueryOutput[]
     */
    public function execute(): array
    {
        $result = [];
        $tasks = $this->taskService->listTasks();
        foreach ($tasks as $task) {
            $result[] = $this->mapTaskOutput($task);
        }

        return $result;
    }

    private function mapTaskOutput(Task $task)
    {
        $result = new ListTasksQueryOutput();
        $result->setUuid($task->getUuid());
        $result->setAlias($task->getAlias());
        $result->setType($task->getType());
        $result->setStatus($task->getStatus());
        $result->setTitle($task->getTitle());

        return $result;
    }
}