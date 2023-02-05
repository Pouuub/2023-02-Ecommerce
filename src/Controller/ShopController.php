<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index( ArticleRepository $articleRepository, Request $request): Response
    {
        $data = new SearchData;
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        [$min, $max] = $articleRepository->findMinMax($data);
        $articles = $articleRepository->findSearch($data);

        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('shop/_articles.html.twig', ['articles' => $articles]),
                'sorting' => $this->renderView('shop/_sorting.html.twig', ['articles' => $articles]),
                'pagination' => $this->renderView('shop/_pagination.html.twig', ['articles' => $articles])
            ]);
        }
        
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'articles' => $articles,
            'form' => $form,
            'min' => $min,
            'max' => $max
        ]);
    }
}
