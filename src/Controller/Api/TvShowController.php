<?php

namespace App\Controller\Api;

use App\Entity\Tvshow;
use App\Repository\TvshowRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/tvshows', name: 'api_tvshows_')]
class TvShowController extends AbstractController
{


    /**
     * retourne toutes les séries du site
     *
     * @return Response
     */
    #[Route(' ', name: 'list', methods: 'GET')]
    public function index(TvshowRepository $tvshowRepository): Response
    {

        $tvshows = $tvshowRepository->findAll();
        //\dd($tvshows);
        return $this->json($tvshows, 200, [], [
            'groups' =>  'groupsTvshows'
        ]);
    }

    #[Route('/{id}', name: 'details', methods: 'GET')]
    public function details(Tvshow $tvshow)
    {
        return $this->json($tvshow, 200, [], [
            'groups' => 'groupsTvshows'
        ]);
    }

    /**
     * Méthode d'ajout d'une série 
     *
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @param ManagerRegistry $doctrine
     * @return void
     */
    #[Route(' ', name: 'add', methods: 'POST')]
    public function  addShow(Request $request, SerializerInterface $serializerInterface, ManagerRegistry $doctrine)
    {
        // Je récupère du texte en Json 
        $JsonData = $request->getContent();
        // Je transforme mon Json en objet //=> Déserialisation 
        // Json //=> OBJECT
        $tvshow = $serializerInterface->deserialize($JsonData, Tvshow::class, 'json');

        // J'appelle mon manager pour sauvegarder en BDD
        $em = $doctrine->getManager();
        $em->persist($tvshow);
        $em->flush();
        // Ensuite je retourne ma réponse au client (Insomnia...)
        return $this->json(
            [
                'message' => 'La série ' . $tvshow->getTitle() . 'a bien été créer'
            ],
            201 //=> 201 created 

        );
    }
}
