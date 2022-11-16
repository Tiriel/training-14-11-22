<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\OmdbMovieTransformer;

class MovieProvider
{
    private OmdbApiConsumer $consumer;
    private OmdbMovieTransformer $transformer;
    private MovieRepository $repository;

    public function __construct(
        OmdbApiConsumer $consumer,
        OmdbMovieTransformer $transformer,
        MovieRepository $repository
    )
    {
        $this->consumer = $consumer;
        $this->transformer = $transformer;
        $this->repository = $repository;
    }

    public function getMovie(string $type, string $value): Movie
    {
        if (!\in_array($type, [OmdbApiConsumer::MODE_TITLE, OmdbApiConsumer::MODE_ID])) {
            throw new \InvalidArgumentException();
        }

        $data = $this->consumer->consume($type, $value);
        if ($movie = $this->repository->findOneBy(['title' => $data['Title']])) {
            return $movie;
        }

        $movie = $this->transformer->transform($data);
        $this->repository->add($movie, true);

        return $movie;
    }
}