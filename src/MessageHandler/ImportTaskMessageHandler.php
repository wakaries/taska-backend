<?php

namespace App\MessageHandler;

use App\Application\Task\PersistTaskAction;
use App\Application\Task\TaskObject;
use App\Domain\Core\Entity\Task;
use App\Infrastructure\Doctrine\Repository\ItemRepository;
use App\Message\ImportTaskMessage;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;

final class ImportTaskMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ItemRepository $itemRepository,
        private UserRepository $userRepository,
        private PersistTaskAction $persistTaskAction,
        private EntityManagerInterface $em,
        private HubInterface $hub
    ) {}

    public function __invoke(ImportTaskMessage $message)
    {
        try {
            $item = $this->itemRepository->find($message->getItemId());
            $line = str_getcsv($item->getData(), "\t");
            $task = new TaskObject();
            $task->setUuid(Uuid::v6());
            $task->setStatus('todo');
            $task->setEpic($line[0]);
            $task->setAlias($line[1]);
            $task->setTitle($line[2]);
            $task->setDescription($line[3]);
            $task->setType($line[4]);
            $user = $this->userRepository->find(1205);
            $this->persistTaskAction->execute($user, $task);    
        } catch(\Throwable $e) {
            $item->setStatus('error');
            $this->em->flush();
            return;
        }
        $item->setStatus('ok');
        $this->em->flush();

        $total = 0;
        $success = 0;
        $error = 0;
        foreach($item->getImport()->getItems() as $item) {
            if ($item->getStatus() == 'ok') {
                $success++;
            }
            if ($item->getStatus() == 'error') {
                $error++;
            }
            $total++;
        }
        $successPercentage = $success / $total * 100;
        $errorPercentage = $error / $total * 100;

        $data = json_encode([
            'status' => [
                'success' => $successPercentage,
                'error' => $errorPercentage
            ]
        ]);
        $update = new Update('https://loquesea/asdf', $data, false);
        $this->hub->publish($update);
    }
}
