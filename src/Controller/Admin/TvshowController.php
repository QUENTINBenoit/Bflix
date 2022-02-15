<?php

namespace App\Controller\Admin;

use App\Entity\Tvshow;
use App\Repository\TvshowRepository;
use Doctrine\Persistence\ManagerRegistry;
use Stringable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TvshowType;


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


    /**
     * Methode afichant le detail d'une serie
     *
     * @param Tvshow $tvshow
     * @return Response
     */
    #[Route('/{id}',  name: 'show')]
    public function show(Tvshow $tvshow): Response
    {
        \dump($tvshow);
        return $this->render('admin/tvshow/show.html.twig', [
            'tvshow' => $tvshow
        ]);
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route('/add', name: 'add')]
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $tvshow = new Tvshow(Stringable::class);
        $form = $this->createForm(TvshowType::class, $tvshow);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($tvshow);
            $em->flush();
            // petit message flash pour indiquer la reussite de le creation de notre nouvelle serie
            $this->addFlash('info', 'la serire ' . $tvshow->getTitle() . 'a bien été enregistré ');
            // redirection a la liste des series parti administration 
            return $this->redirectToRoute('admin_tvshow_list');
        }
        // sinon j'affiche un formulaire d'ajout d'une série 
        return $this->render('admin/tvshow/add.html.twig',  [
            'formView' => $form->createView(),
        ]);
    }
}
