<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
