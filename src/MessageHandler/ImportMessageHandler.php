<?php

namespace App\MessageHandler;

use App\Message\ImportMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ImportMessageHandler implements MessageHandlerInterface
{
    public function __construct()
    {
        
    }

    public function __invoke(ImportMessage $message)
    {
        //$import = $this->importRepository->find($message->getImportId());
        //...
    }
}
