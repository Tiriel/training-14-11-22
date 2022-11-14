<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("", name="app_movie_index")
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="app_movie_details")
     */
    public function details(int $id): Response
    {
        $movie = [
            'title' => 'Star Wars : Episode IV - A New Hope',
            'releasedAt' => new \DateTimeImmutable('1977-05-25'),
            'genre' => [
                'Action',
                'Adventure',
                'Fantasy',
            ],
        ];

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
