<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    // #[Route('/user', name: 'user')]
    // public function user(): Response
    // {
    //     return $this->render('user/index.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('Save')->isClicked()) {
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirect($this->generateUrl('user_show'));
            }
        } else if ($form->get('Cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('user_show'));
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/show', name: 'show')]
    public function show(UserRepository $entityController): Response
    {
        $user = $entityController->findAll();

        return $this->render('user/show.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, UserRepository $entityController, $id)
    {
        // creating the entity manager
        $user = $entityController->find($id);
        $entityManager->remove($user);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->redirect($this->generateUrl('user_show'));
    }


    #[Route('/update/{id}', name: 'update')]
    public function update(EntityManagerInterface $entityManager, Request $request, UserRepository $entityController, $id): Response
    {
        $user = $entityController->find($id);
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->get('Save')->isClicked() && $form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirect($this->generateUrl('user_show'));
        } else if ($form->get('Cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('user_show'));
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}