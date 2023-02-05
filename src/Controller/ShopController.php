<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index( ArticleRepository $articleRepository, Request $request): Response
    {
        $data = new SearchData;
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        //dd($data);
        $articles = $articleRepository->findSearch($data);
        
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'articles' => $articles,
            'form' => $form
        ]);
    }
}
