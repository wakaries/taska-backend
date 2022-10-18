<?php

namespace App\Infrastructure\Symfony\Frontend\Controller;

use App\Repository\ProjectRepository;
use App\Repository\SpaceRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestDoctrineController extends AbstractController
{
    #[Route('/test/doctrine', name: 'app_test_doctrine')]
    public function index(
        SpaceRepository $spaceRepository, 
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository
        ): Response {
            $space = $spaceRepository->findOneBy(['alias' => 'space-419']);
            /*
        $projectList1 = $projectRepository->findBy(['space' => $space]);
        $projectList2 = $projectRepository->listBySpaceDQL($space);
        $projectList3 = $projectRepository->listBySpaceQueryBuilder($space);
        */

        $project = $projectRepository->find(201);
        $taskList = $taskRepository->listByProjectDQL($project);
//        foreach ($taskList as $task) {
//            $epic = $task->getEpic();
//            $epic->getAlias();
//            $task->getWorklogs();
//        }

        $projectList = $projectRepository->listTaskCountBySpaceQueryBuilder($space);

        return $this->render('test_doctrine/index.html.twig', [
            'tasks' => $taskList,
            'projectList' => $projectList
        ]);
    }
}
