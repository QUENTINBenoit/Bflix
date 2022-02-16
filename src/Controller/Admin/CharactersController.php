<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/characters', name: 'admin_characters_')]
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

    #[Route('/{id}', name: 'show')]
    public function detailsCharacter(Character $character): Response
    {
        //  \dd($character);
        return $this->render('amdin/characters/show.html.twig', [
            'character' => $character,
        ]);
    }
}
