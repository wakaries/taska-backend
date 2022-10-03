<?php

namespace App\Controller\Api;

use App\Entity\Task;
use App\Repository\EpicRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Uid\Uuid;

#[Route('/api/tasks')]
class TaskController extends AbstractController
{
    public function __construct(
        private TaskRepository $taskRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('', methods:['GET'])]
    public function index(Request $request): Response
    {
        $params = $request->query->all();
        $tasks = $this->taskRepository->filter($params);
        $tasksResponse = [];
        foreach ($tasks as $task) {
            $tasksResponse[] = [
                'uuid' => $task->getUuid(),
                'title' => $task->getTitle(),
                'status' => $task->getStatus(),
                'project' => $task->getEpic()->getProject()->getAlias(),
            ];
        }
        return new JsonResponse($tasksResponse);
    }

    #[Route('/{uuid}', methods:['GET'])]
    public function detail($uuid): Response
    {
        $task = $this->taskRepository->getByUuid($uuid);
        return new JsonResponse($task);
    }

    #[Route('', methods:['POST'])]
    public function new(UserRepository $userRepository, EpicRepository $epicRepository, Request $request): Response {
        $this->em->beginTransaction();
        $body = json_decode($request->getContent(), true);
        $task = new Task();
        $task->setUuid('PENDING');
        $task->setTitle($body['title']);
        $task->setDescription($body['description']);
        $task->setType($body['type']);
        $slugger = new AsciiSlugger();
        $alias = $slugger->slug($task->getTitle());
        $task->setAlias($alias);
        $task->setStatus('active');
        $task->setCreationDate(new \DateTime());
        $user = $userRepository->find(404); // TODO Cambiar por usuario de sesión
        $task->setCreationUser($user);
        $epic = $epicRepository->findOneBy(['uuid' => $body['epic']]);
        $task->setEpic($epic);
        $this->em->persist($task);
        $this->em->flush();

        $namespace = Uuid::v4();
        $id = $task->getId();
        $task->setUuid(Uuid::v3($namespace, $id));

        $this->em->flush();
        $this->em->commit();

        return $this->json([
            'uuid' => $task->getUuid()
        ]);
    }

    /*
    #[Route('/api/projects/{uuid}', methods:['PATCH'])]
    public function update(Request $request, $uuid): Response
    {
        $body = json_decode($request->getContent(), true);
        $project = $this->projectRepository->findOneBy(['uuid' => $uuid]);
        if (isset($body['alias'])) {
            $project->setAlias($body['alias']);
        }
        if (isset($body['name'])) {
            $project->setName($body['name']);
        }
        if (isset($body['description'])) {
            $project->setDescription($body['description']);
        }
        $this->em->flush();

        return $this->json([
            'uuid' => $project->getUuid()
        ]);
    }

    #[Route('/api/projects/{uuid}', methods:['DELETE'])]
    public function delete($uuid): Response
    {
        $project = $this->projectRepository->findOneBy(['uuid' => $uuid]);
        $this->em->remove($project);
        $this->em->flush();

        return $this->json([
            'uuid' => $project->getUuid()
        ]);
    }
    */
}
