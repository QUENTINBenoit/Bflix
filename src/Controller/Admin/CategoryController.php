<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Stringable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/category', name: 'admin_category_', requirements: ['id' => '\d+'])]
class CategoryController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function categoryList(CategoryRepository $categoryRepository): Response
    {
        //\dd($categoryRepository->findAll());
        return $this->render('admin/category/list.html.twig', [
            'listCategory' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/add', name: 'add')]
    public function categoryAdd(Request $request,  ManagerRegistry $doctrine): Response
    {
        //\dd("page d'ajout d'une catégorie");
        // création d'une entité vide 
        $category = new Category(Stringable::class);
        // liaison de mon entité Category avec mon formulaire
        $form = $this->createForm(CategoryType::class, $category);
        // injection des données via la méthode request issue de mon formulaire dans l'objet $category
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            // petit message flash 
            $this->addFlash('info', 'La catégorie ' . $category->getName() . ' à bien été enregistré');
            return $this->redirectToRoute('admin_category_list');
        }
        return $this->render('admin/category/add.html.twig', [
            'formCatego' => $form->createView(),
        ]);
    }
}
