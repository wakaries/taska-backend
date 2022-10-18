<?php

namespace App\Controller\Admin1;

use App\Application\Task\ListTasksQuery;
use App\Domain\Task\TaskNotificationService;
use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\WorklogRepository;
use App\Security\Voter\TaskVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

class TaskController extends AbstractController
{
    public function __construct(private TaskRepository $taskRepository, private EntityManagerInterface $em) {}

    #[Route('/admin1/task')]
    public function index(ListTasksQuery $listTasksQuery): Response
    {
        $tasks = $listTasksQuery->execute();
        return $this->render('admin1/task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/admin1/task/{uuid}')]
    public function detail($uuid, WorkflowInterface $storyStateMachine): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $this->denyAccessUnlessGranted(TaskVoter::VIEW, $task);
        $transitions = $storyStateMachine->getEnabledTransitions($task);
        return $this->render('admin1/task/detail.html.twig', [
            'task' => $task,
            'transitions' => $transitions,
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

    #[Route('/admin1/task/worklog/{uuid}')]
    public function worklog($uuid, WorklogRepository $worklogRepository): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $worklogs = $worklogRepository->findBy(['task' => $task], ['date' => 'DESC']);
        return $this->render('admin1/task/_worklog.html.twig', [
            'task' => $task,
            'worklogs' => $worklogs
        ]);
    }

    #[Route('/admin1/task/{uuid}/changestatus/{transition}')]
    public function changestatus($uuid, $transition, WorkflowInterface $storyStateMachine, TaskNotificationService $taskNotificationService): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $storyStateMachine->apply($task, $transition);
        $this->em->flush();

        $taskNotificationService->sendNotification();
        
        return $this->redirectToRoute('app_admin1_task_detail', [
            'uuid' => $task->getUuid()
        ]);
    }

    #[Route('/admin1/task/edit/{uuid}')]
    public function edit(Request $request, $uuid = null): Response
    {
        if ($uuid == null) {
            $task = new Task();
            // TODO Definir valores por defecto
        } else {
            $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
            $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);
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
            'form' => $form->createView()
        ]);
    }

}
