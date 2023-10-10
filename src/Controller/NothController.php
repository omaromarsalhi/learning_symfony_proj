<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NothController extends AbstractController
{
    #[Route('/noth', name: 'app_noth')]
    public function index(): Response
    {
        return $this->render('noth/index.html.twig', [
            'controller_name' => 'NothController',
        ]);
    }
}
