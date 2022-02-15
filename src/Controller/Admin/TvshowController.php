<?php

namespace App\Controller\Admin;

use App\Entity\Tvshow;
use App\Repository\TvshowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/tvshow', name: 'admin_tvshow_', requirements: ['id' => '\d+'])]
class TvshowController extends AbstractController
{

    /**
     * Méthode affichant la liste des séries partie administration 
     *
     * @param TvshowRepository $tvshowRepository
     * @return Response
     */
    #[Route('/list', name: 'list')]
    public function index(TvshowRepository $tvshowRepository): Response
    {

        $listSerie = $tvshowRepository->findAllOrderAlpha();
        //  dd($listSerie);
        return $this->render('admin/tvshow/index.html.twig', [
            'tvshowadmin' => $tvshowRepository->findAllOrderAlpha(),
        ]);
    }
    #[Route('/{id}',  name: 'show')]
    public function show(Tvshow $tvshow): Response
    {
        \dump($tvshow);
        return $this->render('admin/tvshow/show.html.twig', [
            'tvshow' => $tvshow
        ]);
    }
}
