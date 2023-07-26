<?php

namespace App\Controller;

use App\Repository\JokeRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(JokeRepository $jokeRepository, CategoryRepository $categoryRepository): Response
    {
        $jokes = $jokeRepository->findBy([], null, 5);
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'jokes' => $jokes,
            'categories' => $categories,
        ]);
    }
}
