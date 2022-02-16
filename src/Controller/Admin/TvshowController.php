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
        return $this->render('admin/tvshow/index.html.twig', [
            'tvshowadmin' => $tvshowRepository->findAllOrderAlpha(),
        ]);
    }


    /**
     * Méthode affichant le détail d'une série
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
     * Méthode permettant d'ajouter une série 
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route('/add', name: 'add')]
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $tvshow = new Tvshow();

        $form = $this->createForm(TvshowType::class, $tvshow);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($tvshow);
            $em->flush();
            // petit message flash pour indiquer la réussite de la création de notre nouvelle série
            $this->addFlash('info', 'la série ' . $tvshow->getTitle() . 'a bien été enregistré ');
            // redirection a la liste des series parti administration 
            return $this->redirectToRoute('admin_tvshow_list');
        }
        // sinon j'affiche un formulaire d'ajout d'une série 
        return $this->render('admin/tvshow/add.html.twig',  [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Tvshow $tvshow
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Tvshow $tvshow, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $em->remove($tvshow);
        $em->flush();
        $this->addFlash('success', 'Serire supprimée avec succes');
        return $this->redirectToRoute('admin_tvshow_list');
    }



    #[Route('/edit/{id}', name: 'edit')]

    public function edit(Tvshow $tvshow,  Request $request, ManagerRegistry $doctrine)
    {

        $form = $this->createForm(TvshowType::class, $tvshow);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            $this->addFlash('success', 'la série ' . $tvshow->getTitle() . ' a bien été mise à jour');
            return $this->redirectToRoute('admin_tvshow_show', ['id' => $tvshow->getId()]);
        }
        return $this->render('admin/tvshow/edit.html.twig', [
            'formEdit' => $form->createView(),
            'tvshow' => $tvshow
        ]);
    }
}
