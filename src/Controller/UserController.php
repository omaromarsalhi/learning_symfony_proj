<?php

namespace App\Controller;

use App\Entity\User;
use App\Validator\EntitiesValidator;
use App\Validator\Entities;
use App\Form\UserFormType;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
    public function create(EntityManagerInterface $entityManager, Request $request, UserPasswordEncoderInterface  $passwrodEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('Save')->isClicked()) {
                $user->setPassword($passwrodEncoder->encodePassword($user, $form->get('password')->getData()));
                $user->setRoles(['ROLE_USER']);

                $file = $form->get('image')->getData();
                if ($file) {
                    $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();

                    $file->move(
                        $this->getParameter('upload_path'),
                        $fileName
                    );

                    $user->setImage($fileName);
                }



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
        $form = $this->createForm(UserUpdateType::class, $user);

        $form->handleRequest($request);

        if ($form->get('Save')->isClicked() && $form->isSubmitted()) {

            $validator = new EntitiesValidator($entityManager);
            $bool = $validator->validate4Update($user->getId(), $user->getEmail(), new Entities());

            $file = $form->get('image')->getData();

            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
                $file->move(
                    $this->getParameter('upload_path'),
                    $fileName
                );

                $user->setImage($fileName);
            }

            if ($bool) {
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
}
