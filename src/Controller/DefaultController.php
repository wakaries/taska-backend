<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\LocaleSwitcher;

class DefaultController extends AbstractController
{
    #[Route('/setlocale/{locale}')]
    public function setLocale($locale, LocaleSwitcher $localeSwitcher): Response
    {
        $localeSwitcher->setLocale($locale);
        return $this->redirectToRoute('app_admin1_task_index');
    }
}
