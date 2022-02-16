<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharactersController extends AbstractController
{
    #[Route('/admin/characters', name: 'admin_characters')]
    public function list(CharacterRepository $characterRepository)
    {
        $characterList = $characterRepository->findAll();
        dd($characterList);

        return $this->render('admin/characters/index.html.twig', [
            'controller_name' => 'CharactersController',
        ]);
    }
}
