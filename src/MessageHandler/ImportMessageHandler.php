<?php

namespace App\MessageHandler;

use App\Domain\Core\Entity\Item;
use App\Infrastructure\Doctrine\Repository\ImportRepository;
use App\Message\ImportMessage;
use App\Message\ImportTaskMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ImportMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ImportRepository $importRepository,
        private EntityManagerInterface $em,
        private MessageBusInterface $messageBus
    ) {
        
    }

    public function __invoke(ImportMessage $message)
    {
        $import = $this->importRepository->find($message->getImportId());

        $fp = fopen('php://temp', 'r+');
        fputs($fp, $import->getData());
        rewind($fp);
        while (($line = fgets($fp)) !== FALSE) {
            $item = new Item();
            $item->setImport($import);
            $item->setData($line);
            $item->setStatus('pending');
            $this->em->persist($item);
        }
        $this->em->flush();
        fclose($fp);

        foreach ($import->getItems() as $item) {
            $message = new ImportTaskMessage();
            $message->setItemId($item->getId());
            $this->messageBus->dispatch($message);
        }

    }
}
