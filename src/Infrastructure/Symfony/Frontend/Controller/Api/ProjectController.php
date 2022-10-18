<?php

namespace App\Infrastructure\Symfony\Frontend\Controller\Api;

use App\Domain\Core\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ProjectController extends AbstractController
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('/api/projects', methods:['GET'])]
    public function index(Request $request): Response
    {
        $params = $request->query->all();
        $projects = $this->projectRepository->filter($params);
        $projectsResponse = [];
        foreach ($projects as $project) {
            $users = [];
            foreach ($project->getUserProjects() as $userProject) {
                $users[] = $userProject->getUser()->getUsername();
            }
            $projectsResponse[] = [
                'uuid' => $project->getUuid(),
                'name' => $project->getName(),
                'status' => $project->getStatus(),
                'space' => $project->getSpace()->getAlias(),
                'users' => $users
            ];
        }
        return new JsonResponse($projectsResponse);
    }

    #[Route('/api/projects/{uuid}', methods:['GET'])]
    public function detail($uuid): Response
    {
        $project = $this->projectRepository->getByUuid($uuid);
        return new JsonResponse($project);
    }

    #[Route('/api/projects', methods:['POST'])]
    public function new(SpaceRepository $spaceRepository, Request $request): Response {
        $this->em->beginTransaction();
        $body = json_decode($request->getContent(), true);
        $space = $spaceRepository->findOneBy(['uuid' => $body['space']]);
        $project = new Project();
        $project->setAlias($body['alias']);
        $project->setName($body['name']);
        $project->setDescription($body['description']);
        $project->setSpace($space);
        $project->setUuid('TEMP');
        $project->setStatus('active');
        $this->em->persist($project);
        $this->em->flush();
        $namespace = Uuid::v4();
        $id = $project->getId();
        $project->setUuid(Uuid::v3($namespace, $id));
        $this->em->flush();
        $this->em->commit();

        return $this->json([
            'uuid' => $project->getUuid()
        ]);
    }

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

}
