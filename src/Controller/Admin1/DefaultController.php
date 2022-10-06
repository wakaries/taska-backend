<?php

namespace App\Controller\Admin1;

use App\Repository\SpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/admin1/default', name: 'app_admin1_default')]
    public function index(SpaceRepository $spaceRepository): Response
    {
        $spaces = $spaceRepository->findAll();
        return $this->render('admin1/default/index.html.twig', [
            'spaces' => $spaces
        ]);
    }
}
