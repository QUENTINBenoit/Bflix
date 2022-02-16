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


#[Route('/admin/characters', name: 'admin_characters_', requirements: ['id' => '\d+'])]
class CharactersController extends AbstractController
{
    /**
     * Méthode affichant la list des personnages
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
     * Méthode affichant le detail des personnages
     *
     * @param Character $character
     * @return Response
     */
    #[Route('/{id}', name: 'show')]
    public function detailsCharacter(Character $character): Response
    {
        // \dd($character);
        return $this->render('admin/characters/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addCharacters(Request $request, ManagerRegistry $doctrine)
    {
        $character = new Character();
        $form = $this->createForm(CharactersType::class, $character);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
}
