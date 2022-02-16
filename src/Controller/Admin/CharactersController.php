<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharactersController extends AbstractController
{
    #[Route('/admin/characters', name: 'admin_characters')]
    public function index(): Response
    {
        return $this->render('admin/characters/index.html.twig', [
            'controller_name' => 'CharactersController',
        ]);
    }
}
