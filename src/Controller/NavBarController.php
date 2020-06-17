<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavBarController extends AbstractController
{
    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function selectCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('components/_selectCategories.html.twig', [
            'categories' => $categories,
        ]);
    }

}
