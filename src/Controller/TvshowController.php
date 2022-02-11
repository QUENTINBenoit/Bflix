<?php

namespace App\Controller;

use App\Entity\Tvshow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TvshowRepository;
use Stringable;

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
    public function list(TvshowRepository $TvshowRepository,): Response
    {
        $tvshwolist = ($TvshowRepository->findAllOrderAlpha());


        return $this->render('tvshow/list.html.twig', [
            'tvshows' => $tvshwolist,
        ]);
    }


    /**
     * Détail d'une série en fonction de Id
     * @deprecated version 1.1 Remplace par slugger()
     * @param integer $id
     * @param TvshowRepository $tvshowRepository
     * @return Response
     */
    #[Route('/{id}', name: 'details', requirements: ['id' => '\d+'],)]
    public function details(int $id, TvshowRepository $tvshowRepository, Tvshow $tvshow): Response
    {
        $tvShows =  $tvshowRepository->findWithDetails($id);
        //  \dd($tvShows);

        if ($tvShows === null) {
            // On affichi une 404
            // Que l'on peut custumiser   ==> https://symfony.com/doc/current/controller/error_pages.html
            throw $this->createNotFoundException("cette série n'existe pas ");
        }
        // return $this->redirectToRoute('tvshow_slugger', ['slug' => $tvshow->getSlug()], 301);
        return $this->redirectToRoute('tvshow_slugger', ['slug' => $tvshow->getSlug()], 301);
    }



    /**
     *  Détail d'une série en fonction de son slug
     * @param Tvshow $tvshow
     * @return Response
     */
    #[Route('/details/{slug}', name: 'slugger',)]
    public function slugger(Tvshow $tvshow): Response
    {
        return $this->render('tvshow/details.html.twig', [
            'tvshow' => $tvshow,

        ]);
    }
}
