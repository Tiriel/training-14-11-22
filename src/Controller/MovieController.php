<?php

namespace App\Controller;

use App\Consumer\OmdbApiConsumer;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieVoter;
use App\Transformer\OmdbMovieTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("", name="app_movie_index")
     */
    public function index(MovieRepository $repository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="app_movie_details")
     */
    public function details(int $id, MovieRepository $repository): Response
    {
        $movie = $repository->find($id);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/omdb/{title}", name="app_movie_omdb", methods={"GET"})
     */
    public function omdb(string $title, MovieProvider $provider): Response
    {
        $movie = $provider->getMovie(OmdbApiConsumer::MODE_TITLE, $title);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
