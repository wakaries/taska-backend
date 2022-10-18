<?php
namespace App\Domain\Task;

use App\Repository\TaskRepository;

class TaskService
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function listAll()
    {
        return $this->taskRepository->findAll();
    }
}