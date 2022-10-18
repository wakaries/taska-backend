<?php

namespace App\Domain\Task\Service\Task;

use App\Repository\TaskRepository;

class TaskService {

    public function __construct(private TaskRepository $taskRepository) {}

    public function listTasks()
    {
        $tasks = $this->taskRepository->findAll();

        return $tasks;
    }

}