<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{
    // #[Route('/chat', name: 'app_chat')]
    // public function index(): Response
    // {
    //     return $this->render('chat/index.html.twig', [
    //         'controller_name' => 'ChatController',
    //     ]);
    #[Route('/show', name: 'show')]
    public function show(): Response
    {
        return $this->render('chat/show.html.twig');
    }
}
