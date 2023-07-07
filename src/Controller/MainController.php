<?php

namespace App\Controller;

use App\Service\MoviesDatabaseApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $moviesDatabaseApi;
    
    public function __construct(MoviesDatabaseApi $moviesDatabaseApi)
    {
        $this->moviesDatabaseApi = $moviesDatabaseApi;
    }

    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $categories = $this->moviesDatabaseApi->getCategories();
        
        return $this->render('page/main.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function notFound(): Response
    {
        // return $this->render('404.html.twig', [], Response::HTTP_NOT_FOUND);
        return $this->render('page/404.html.twig');
    }
}
