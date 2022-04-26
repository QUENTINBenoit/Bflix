<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/categories', name: 'api_categories_')]
class CategoryController extends AbstractController
{
    /**
     * Retourne la liste des catégories en JSON
     *
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200, [], [
            'groups' => 'groupsCategories'
        ]);
    }

    /**
     * Retourne une Catégorie en fonction de son ID
     *
     * @param Category $category
     * @return Response
     */
    #[Route('/{id}', name: 'details', methods: ['GET'])]
    public function deatils(Category $category): Response
    {

        return $this->json($category, 200, [], [
            'groups' => 'groupsCategories'
        ]);
    }

    /**
     * Création d'une nouvelle catégorie
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validatorInterface
     * @return Response
     */
    #[Route("/", name: 'add', methods: ['POST'])]
    public function add(Request $request, ManagerRegistry $doctrine,  SerializerInterface $serializer, ValidatorInterface $validatorInterface): Response
    {
        // Je récupère les données au format JSON
        $jsonDataj = $request->getContent();

        // Je convertis les données en objet en les désérialisant
        $category = $serializer->deserialize($jsonDataj, Category::class, 'json');
        $errors = $validatorInterface->validate($category);
        if (\count($errors) > 0) {
            // J' ajoute un message d'erreur
            $errorsString = (string) $errors;
            return $this->json(
                [
                    'message' => $errorsString
                ],
                500 //=> type error
            );
        } else {
            // j'appelle mon manager pour sauvegarder en BDD
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();
            // Je retourne une réponse au client (Insomnie...)
            return $this->json(
                [
                    'message' => 'la catégorie ' . $category->getName() . ' a bien été créée'
                ],
                201 //=>  code type requete created
            );
        }
    }


    #[Route("/{id}", name: 'update', methods: ['PUT|PATCH'])]
    public function update(Category $category, Request $request)
    {
        $jsonData = $request->getContent();
    }
}
