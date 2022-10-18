<?php

namespace App\Tests;

use App\Domain\Task\TaskNotificationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskNotificationServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $taskNotificationService = static::getContainer()->get(TaskNotificationService::class);
        $taskNotificationService->sendNotification();
    }
}
