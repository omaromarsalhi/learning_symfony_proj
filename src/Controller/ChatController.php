<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/save', name: 'save')]
    public function saveMsg(Request $request, UserRepository $entityController, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $ali = $entityController->find(2);
        if ($user) {
            if ($request->isXmlHttpRequest()) {
                $curentChat = new Chat();
                $curentChat->setBody($request->get('body'));
                $curentChat->setSentAt(new \DateTimeImmutable());
                $curentChat->setSenderId($user);
                $curentChat->setReciverId($ali);
                $curentChat->setViewedOrNot(false);
                $entityManager->persist($curentChat);
                $entityManager->flush();
                return $this->json(['user' => $user, 'result' => "success", 'chat' => $curentChat]);
            }
        }
        // return $this->render('chat/show.html.twig');
    }
}
