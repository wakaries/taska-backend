<?php

namespace App\Application\Task;

use App\Domain\Core\Entity\Task;
use App\Domain\Core\Entity\User;
use App\Repository\EpicRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class PersistTaskAction {

    public function __construct(private EntityManagerInterface $em, private TaskRepository $taskRepository, private EpicRepository $epicRepository) {}

    public function execute(User $user, TaskObject $input): void
    {
        $task = $this->taskRepository->getByUuid(['uuid' => $input->getUuid()]);
        if ($task == null) {
            $task = new Task();
            $task->setUuid($input->getUuid());
            $task->setCreationDate(new \DateTime());
            $task->setCreationUser($user);
        }
        $task->setTitle($input->getTitle());
        $task->setType($input->getType());
        $task->setStatus($input->getStatus());
        $task->setAlias($input->getAlias());
        $task->setDescription($input->getDescription());
        $epic = $this->epicRepository->findOneBy(['uuid' => $input->getEpic()]);
        $task->setEpic($epic);

        $this->em->persist();
        $this->em->flush();

        // TODO Enviar evento
    }
}