<?php

namespace App\Controller;

use App\Service\MoviesDatabaseApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private $moviesDatabaseApi;
    
    public function __construct(MoviesDatabaseApi $moviesDatabaseApi)
    {
        $this->moviesDatabaseApi = $moviesDatabaseApi;
    }
    
    #[Route('/movies', name: 'app_movies')]
    public function movies(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $titleMovie = $request->query->get('titleMovie');
        $yearMovie = $request->query->get('year');
        $genre = $request->query->get('genre');

        if($titleMovie){
            $movies = $this->moviesDatabaseApi->searchMoviesByTitle($titleMovie, $page, $yearMovie, $genre);
            // $movies = $this->moviesDatabaseApi->searchMoviesByTitle($titleMovie);
        }else{
            $movies = $this->moviesDatabaseApi->getMovies($page, $yearMovie, $genre);
        }
        $categories = $this->moviesDatabaseApi->getCategories();

        return $this->render('page/movies.html.twig', [
            'movies' => $movies,
            'titleMovie' => $titleMovie,
            'categories' => $categories,
            'page' => $page,
        ]);
    }

    #[Route('/movie/{idFilm}', name: 'single_movie')]
    public function singleMovie($idFilm): Response
    {
        $movie = $this->moviesDatabaseApi->getMovieDetails($idFilm);

        // Traite les informations du film récupérées de l'API et passe-les à la vue

        if($movie['results'] != null){
            return $this->render('page/movie_details.html.twig', [
                'movie' => $movie['results'],
            ]);
        }else{
            return $this->render('page/movie_not_found.html.twig');
        }
    }

    #[Route('/actors', name: 'app_actors')]
    public function actors(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $nameActor = $request->query->get('nameActor');

        $actors = $this->moviesDatabaseApi->getActors($page);

        return $this->render('page/actors.html.twig', [
            'actors' => $actors,
        ]);
    }
}
