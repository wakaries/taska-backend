<?php

namespace App\Controller\Admin1;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/admin1/task/{uuid}')]
    public function detail($uuid): Response
    {
        $task = $this->taskRepository->findOneBy(['uuid' => $uuid]);
        return $this->render('admin1/task/detail.html.twig', [
            'task' => $task,
            'section' => 'tasks'
        ]);
    }

}
