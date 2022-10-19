<?php

namespace App\Infrastructure\Symfony\Frontend\Controller\Admin1;

use App\Application\Task\DetailTaskQuery;
use App\Application\Task\PersistTaskAction;
use App\Application\Task\PersistTaskInput;
use App\Application\Task\TaskObject;
use App\Domain\Core\Entity\Task;
use App\Infrastructure\Symfony\Frontend\Form\TaskType;
use App\Infrastructure\Symfony\Security\Voter\TaskVoter;
use App\Repository\TaskRepository;
use App\Repository\WorklogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

class TaskController extends AbstractController
{
    public function __construct(private TaskRepository $taskRepository, private EntityManagerInterface $em) {}

    #[Route('/admin1/task', name: 'app_admin1_task_index')]
    public function index(): Response
    {
        $tasks = $this->taskRepository->filter([]);
        return $this->render('admin1/task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/admin1/task/{uuid}/detail', name: 'app_admin1_task_detail')]
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

    #[Route('/admin1/task/worklog/{uuid}', name: 'app_admin1_task_worklog')]
    public function worklog($uuid, WorklogRepository $worklogRepository): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $worklogs = $worklogRepository->findBy(['task' => $task], ['date' => 'DESC']);
        return $this->render('admin1/task/_worklog.html.twig', [
            'task' => $task,
            'worklogs' => $worklogs
        ]);
    }

    #[Route('/admin1/task/{uuid}/changestatus/{transition}', name: 'app_admin1_task_changestatus')]
    public function changestatus($uuid, $transition, WorkflowInterface $storyStateMachine): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        $storyStateMachine->apply($task, $transition);
        $this->em->flush();
        return $this->redirectToRoute('app_admin1_task_detail', [
            'uuid' => $task->getUuid()
        ]);
    }

    #[Route('/admin1/task/edit/{uuid}', name: 'app_admin1_task_edit')]
    public function edit(Request $request, DetailTaskQuery $detailTaskQuery, PersistTaskAction $persistTaskAction, $uuid = null): Response
    {
        if ($uuid == null) {
            $task = new TaskObject();
            $task->setUuid('qwer');
        } else {
            $task = $detailTaskQuery->execute($uuid);
            //$this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persistTaskAction->execute($this->getUser(), $task);
            return $this->redirectToRoute('app_admin1_task_index');
        }
        return $this->render('admin1/task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }

}
