<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TvshowRepository;

#[Route('/tvshow', name: 'tvshow_')]
class TvshowController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(TvshowRepository $TvshowRepository): Response
    {
        return $this->render('tvshow/list.html.twig', [
            'tvshows' => $TvshowRepository->findAll(),
        ]);
    }
}
