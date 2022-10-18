<?php

namespace App\Infrastructure\Symfony\Frontend\Controller\Admin2;

use App\Domain\Core\Entity\Task;
use App\Infrastructure\Symfony\Frontend\Form\TaskType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin2/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_admin2_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('admin2/task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin2_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->find(201);
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, [
            'project' => $project
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin2_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin2/task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin2_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('admin2/task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin2_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin2_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin2/task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin2_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin2_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
