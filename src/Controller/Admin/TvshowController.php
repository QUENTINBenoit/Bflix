<?php

namespace App\Controller\Admin;

use App\Repository\TvshowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/tvshow', name: 'admin_tvshow_')]
class TvshowController extends AbstractController
{

    /**
     * Méthode affichant la liste des séries administration 
     *
     * @param TvshowRepository $tvshowRepository
     * @return Response
     */
    #[Route('/list', name: 'list')]
    public function index(TvshowRepository $tvshowRepository): Response
    {

        $listSerie = $tvshowRepository->findAllOrderAlpha();
        //dd($listSerie);
        return $this->render('admin/tvshow/index.html.twig', [
            'tvshowadmin' => $tvshowRepository->findAllOrderAlpha(),
        ]);
    }
}
