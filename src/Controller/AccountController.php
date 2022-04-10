<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/account', name: 'account_')]
class AccountController extends AbstractController
{
    #[Route('/{id}', name: 'user', requirements: ['id' => '\d+'])]
    public function accountUser(
        Request $request,
        User $user,
        EntityManagerInterface $doctrine,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {
        $this->denyAccessUnlessGranted('USER_EDIT', $user, "Vous n'avez pas les droits pour modifier ce compte");

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Réception du mot de passe 

            $password = $form->get('password')->getData();
            // Je hash le mot de passe 
            $motDePassHacher = $userPasswordHasher->hashPassword($user, $password);
            // Mise ajour de la  propriété "password avec le nouveau mot de passe
            $user->setPassword($motDePassHacher);
            $doctrine->flush();
            $this->addFlash('success', 'les données de votre compte ont bien été modifier');
            return $this->redirectToRoute('tvshow_list');
        }
        return $this->renderForm('account/index.html.twig', [
            'user' => $user,
            'formAccount' => $form,
        ]);
    }
}
