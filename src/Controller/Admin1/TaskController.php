<?php

namespace App\Controller\Admin1;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Flex\Response as FlexResponse;

class TaskController extends AbstractController
{
    public function __construct(private TaskRepository $taskRepository, private EntityManagerInterface $em) {}

    #[Route('/admin1/task')]
    public function index(): Response
    {
        $tasks = $this->taskRepository->filter([]);
        return $this->render('admin1/task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/admin1/task/detail/{uuid}')]
    public function detail($uuid): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        return $this->render('admin1/task/detail.html.twig', [
            'task' => $task,
            'section' => 'tasks'
        ]);
    }

    public function comments(Task $task): Response
    {
        $comments = $task->getComments();
        return $this->render('admin1/task/_comments.html.twig', [
            'comments' => $comments
        ]);
    }

    #[Route('/admin1/task/{uuid}/worklog')]
    public function worklog($uuid): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $worklog = $task->getWorklogs();
        return $this->render('admin1/task/_worklog.html.twig', [
            'task' => $task,
            'worklog' => $worklog
        ]);
    }

    #[Route('/admin1/task/edit/{uuid}')]
    public function edit(Request $request, $uuid = null): Response
    {
        if ($uuid == null) {
            $task = new Task();
            $task->setCreationDate(new \DateTime());
            $namespace = Uuid::v4();
            $task->setUuid(Uuid::v3($namespace, uniqid()));

        } else {
            $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('app_admin1_task_index');
        }

        return $this->render('admin1/task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }
}
