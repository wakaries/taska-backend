<?php
namespace App\Application\Task;

use App\Domain\Task\TaskService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ListTasksQuery
{
    public function __construct(
        private TaskService $taskService,
        private ContainerInterface $container
        ) {}

    public function execute()
    {
        $taskService = $this->container->get(TaskService::class);
        $tasks = $this->taskService->listAll();
        return $tasks;
    }
}

