<?php

namespace App\Service;

use GuzzleHttp\Client;

class MoviesDatabaseApi
{
    private $httpClient;
    private $apiKey;
    private $baseUrl;

    public function __construct(string $apiKey, string $baseUrl, int $page = 1, int $yearMovie = null, string $genre = "")
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
        $this->page = $page;
        $this->yearMovie = $yearMovie;
        $this->genre = $genre;

        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'X-RapidAPI-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ],
            'verify' => false       // À supprimer lors de la mise en prod
        ]);
    }

    public function getMovies($page, $yearMovie, $genre)
    {
        $response = $this->httpClient->request('GET', '/titles', [
            'query' => [
                'info' => 'base_info',
                'page' => $page,
                'year' => $yearMovie,
                'genre' => $genre,
                'limit' => 12,
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data;
    }

    public function searchMoviesByTitle($title, $page, $yearMovie, $genre)
    {
        $response = $this->httpClient->request('GET', '/titles/search/title/' .$title, [
            'query' => [
                'exact' => 'false',
                'info' => 'base_info',
                'page' => $page,
                'year' => $yearMovie,
                'genre' => $genre,
                'limit' => 12,
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data;
    }
    /* public function searchMoviesByTitle($title)
    {
        $response = $this->httpClient->request('GET', '/titles/search/title/' .$title, [
            'query' => [
                'exact' => 'false',
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data;
    } */

    public function getMovieDetails($movieId)
    {
        $response = $this->httpClient->request('GET', '/titles/'.$movieId, [
            'query' => [
                'info' => 'base_info',
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data;
    }

    public function getActors($page)
    {
        $response = $this->httpClient->request('GET', '/actors', [
            'query' => [
                'page' => $page,
                'limit' => 12,
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        foreach ($data['results'] as &$actor) {
            $knownForTitles = explode(',', $actor['knownForTitles']);
            $actor['knownForMovies'] = [];

            foreach ($knownForTitles as $movieId) {
                $movieDetails = $this->getMovieDetails($movieId);
                $actor['knownForMovies'][] = $movieDetails;
            }
        }

        return $data;
    }

    public function getCategories()
    {
        $response = $this->httpClient->request('GET', '/titles/utils/genres');

        $data = json_decode($response->getBody(), true);

        return $data;
    }
}
