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
use Twig\TokenParser\UseTokenParser;

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

    /**
     *  Méthode permettant d'ajouter un utilisateur  
     *
     * @param Request $request
     * @param EntityManagerInterface $doctrine
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @return Response
     */
    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function newUser(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Je récupère le mot de passe en clair
            $plainPassword = $form->get('password')->getData();
            // Je hash le mot de passe
            $hashePassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);
            // Je mets à jour la propriété 'password avec le nouveau mot de pass
            $user->setPassword($hashePassword);
            // sauvegarde en Bdd
            $doctrine->persist($user);
            $doctrine->flush();
            return $this->redirectToRoute('admin_user_list');
        }
        return $this->renderForm('admin/user/add.html.twig',  [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * Méthode affichant le de détail de chaque utilisateur
     *
     * @param User $user
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function showUser(User $user): Response
    {
        // \dd('derail user');
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Méthode permettant de supprimer un utilisateur 
     *
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $doctrine
     * @return Response
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $doctrine->remove($user);
            $doctrine->flush();
        }
        return $this->redirectToRoute('admin_user_list', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Méthode de mise à jour d'un Utilisateur 
     *
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $doctrine
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit')]
    public function editUser(Request $request, User $user,  EntityManagerInterface $doctrine, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $this->denyAccessUnlessGranted('USER_EDTI', $user, "Vous n'avez pas les droits pour modifier ce compte");

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Recuperation du mot de passe 
            $password = $form->get('password')->getData();
            // Je hash le mot de passe 
            $motDePassHacher = $userPasswordHasherInterface->hashPassword($user, $password);
            // mise à jour de la propriété 'password avec le mnouveau mot de passe
            $user->setPassword($motDePassHacher);
            $doctrine->flush();
            return $this->redirectToRoute('admin_user_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
