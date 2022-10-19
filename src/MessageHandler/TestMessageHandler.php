<?php

namespace App\MessageHandler;

use App\Message\TestMessage;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class TestMessageHandler implements MessageHandlerInterface
{
    public function __construct(private HubInterface $hub) {}

    public function __invoke(TestMessage $message)
    {
        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'OutOfStock'])
        );

        $this->hub->publish($update);
    }
}
