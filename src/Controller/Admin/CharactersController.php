<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Form\CharactersType;
use App\Repository\CharacterRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ImageUploader;



#[Route('/admin/characters', name: 'admin_characters_', requirements: ['id' => '\d+'])]
class CharactersController extends AbstractController
{
    /**
     * Méthode affichant la liste des personnages
     *
     * @param CharacterRepository $characterRepository
     * @return Response
     */
    #[Route('/list', name: 'list')]
    public function list(CharacterRepository $characterRepository): Response
    {


        return $this->render('admin/characters/list.html.twig', [
            'charactersList' => $characterRepository->findAll(),
        ]);
    }
    /**
     * Méthode affichant le détail des personnages
     *
     * @param Character $character
     * @return Response
     */
    #[Route('/{id}', name: 'show')]
    public function detailsCharacter(Character $character): Response
    {
        \dump($character);
        return $this->render('admin/characters/show.html.twig', [
            'character' => $character,
        ]);
    }

    /**
     * Méthode permettant d'ajouter un personnage
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route('/add', name: 'add')]
    public function addCharacters(Request $request, ManagerRegistry $doctrine, ImageUploader $imageUploader)
    {
        $character = new Character();
        $form = $this->createForm(CharactersType::class, $character);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Service permettant l'upload d'une image
            $newFileName = $imageUploader->upload($form, 'image');
            // On met à jour le chemin vers l'image en BDD
            $character->setImage($newFileName);

            $em = $doctrine->getManager();
            $em->persist($character);
            $em->flush();
            $this->addFlash('success', 'Le personnage ' . $character->getFirstname() . ' a bien été cré');
            return $this->redirectToRoute('admin_characters_list');
        }

        return $this->render('admin/characters/add.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
    /**
     * Méthode permettant d'éditer un personnage 
     *
     * @param Character $character
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route('/edit/{id}', name: 'edit')]
    public function editCharacters(Character $character, Request $request, ManagerRegistry $doctrine, ImageUploader $imageUploader)
    {

        $form = $this->createForm(CharactersType::class, $character);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Service permettant l'upload d'une image
            $newFileName = $imageUploader->upload($form, 'image');
            $character->setImage($newFileName);

            $em = $doctrine->getManager();
            $em->flush();
            $this->addFlash('success', 'Le personnage  ' . $character->getFirstname() . ' ' . $character->getLastname() . ' à bien été mis à jour ');
            return $this->redirectToRoute('admin_characters_list');
        }
        return $this->render('admin/characters/edit.html.twig', [
            'formEdit' => $form->createView()
        ]);
    }
    /**
     * Méthode de suppression d'un personnage 
     *
     * @param Character $character
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route('/delete/{id}', name: 'delete')]
    public function deleteCharacters(Character $character, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $em->remove($character);
        $em->flush();
        $this->addFlash('success', 'Le personnage ' . $character->getLastname() . ' à bien été supprimé');
        return $this->redirectToRoute('admin_characters_list');
    }
}
