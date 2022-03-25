<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Tvshow;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/characters', name: 'characters_', requirements: ['id' => '\d+'])]
class CharactersController extends AbstractController
{

    /**
     * Méthode affichant le détail des personnages
     *
     * @param Character $character
     * @return Response
     */
    #[Route('/{id}', name: 'display')]
    public function detailsCharacter(Character $character): Response
    {

        return $this->render('/characters/display.html.twig', [
            'character' => $character,

        ]);
    }
}
