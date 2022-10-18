<?php

namespace App\Tests;

use App\Domain\Task\Service\Task\TaskNotificationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskNotificationServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        /** @var TaskNotificationService $taskNotificationService */
        $taskNotificationService = static::getContainer()->get(TaskNotificationService::class);
        $taskNotificationService->sendNotification();
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
