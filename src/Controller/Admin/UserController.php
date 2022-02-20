<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user', name: 'admin_user_', requirements: ['id' => '\d+'])]
//#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    /**
     * Méthode affichant tous les utilisateurs
     *
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function usersList(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function newUser(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Je recupére le mot de passe en claire
            $plainPassword = $form->get('passwor')->getData();
            // Je has le mot de passe
            $hashePassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
            // Je mets a our la propriété 'password avec le nouveau mot de pass
            $user->setPassword($hashePassword);
            // savegarde en Bdd
            $doctrine->persist($user);
            $doctrine->flush();
            return $this->redirectToRoute('admin_user_list');
        }
        return $this->renderForm('admin/user/add.html.twig',  [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
