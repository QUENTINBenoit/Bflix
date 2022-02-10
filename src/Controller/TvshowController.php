<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TvshowRepository;
use Laminas\Code\Reflection\FunctionReflection;

#[Route('/tvshow', name: 'tvshow_')]
class TvshowController extends AbstractController
{
    /**
     * Liste de toutes les séries par ordre alphabétique
     * // via /=> findAllOrderAlpha()
     *
     * @param TvshowRepository $TvshowRepository
     * @return Response
     */
    #[Route('/list', name: 'list')]
    public function list(TvshowRepository $TvshowRepository): Response
    {
        return $this->render('tvshow/list.html.twig', [
            'tvshows' => $TvshowRepository->findAllOrderAlpha(),
        ]);
    }
    #[Route('/{id}', name: 'details', requirements: ['id' => '\d+'],)]
    public function details(int $id, TvshowRepository $tvshowRepository): Response
    {
        $tvShows =  $tvshowRepository->findWithDetails($id);

        return $this->render('tvshow/details.html.twig', [
            'tvshow' => $tvShows,
        ]);
    }
}
