<?php

namespace App\Controller\Admin2;

use App\Entity\Space;
use App\Form\SpaceType;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin2/space')]
class SpaceController extends AbstractController
{
    #[Route('/', name: 'app_admin2_space_index', methods: ['GET'])]
    public function index(SpaceRepository $spaceRepository): Response
    {
        return $this->render('admin2/space/index.html.twig', [
            'spaces' => $spaceRepository->findAll(),
            'title' => 'Spaces'
        ]);
    }

    #[Route('/new', name: 'app_admin2_space_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $space = new Space();
        $form = $this->createForm(SpaceType::class, $space);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($space);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin2_space_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin2/space/new.html.twig', [
            'space' => $space,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin2_space_show', methods: ['GET'])]
    public function show(Space $space): Response
    {
        return $this->render('admin2/space/show.html.twig', [
            'space' => $space,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin2_space_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Space $space, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpaceType::class, $space);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin2_space_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin2/space/edit.html.twig', [
            'space' => $space,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', methods: ['GET'])]
    public function predelete($id, SpaceRepository $spaceRepository): Response
    {
        $space = $spaceRepository->find($id);

        return $this->render('admin2/space/predelete.html.twig', [
            'space' => $space
        ]);
    }


    #[Route('/{id}', name: 'app_admin2_space_delete', methods: ['POST'])]
    public function delete(Request $request, Space $space, EntityManagerInterface $entityManager): Response
    {
        try {
            if ($this->isCsrfTokenValid('delete'.$space->getId(), $request->request->get('_token'))) {
                $entityManager->remove($space);
                $entityManager->flush();
            }    
        } catch(\Exception) {
            
        }

        return $this->redirectToRoute('app_admin2_space_index', [], Response::HTTP_SEE_OTHER);
    }
}
