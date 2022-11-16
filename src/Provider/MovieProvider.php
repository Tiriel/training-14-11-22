<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\OmdbMovieTransformer;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieProvider
{
    private OmdbApiConsumer $consumer;
    private OmdbMovieTransformer $transformer;
    private MovieRepository $repository;
    private ?SymfonyStyle $io;

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

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }

    public function getMovie(string $type, string $value): Movie
    {
        if (!\in_array($type, [OmdbApiConsumer::MODE_TITLE, OmdbApiConsumer::MODE_ID])) {
            throw new \InvalidArgumentException();
        }

        $this->sendIo('text', 'Calling OMDb API.');
        $data = $this->consumer->consume($type, $value);
        if ($movie = $this->repository->findOneBy(['title' => $data['Title']])) {
            $this->sendIo('note', 'Movie already in database!');
            return $movie;
        }

        $this->sendIo('text', 'Movie found, saving in database.');
        $movie = $this->transformer->transform($data);
        $this->repository->add($movie, true);

        return $movie;
    }

    private function sendIo(string $type, string $message)
    {
        if ($this->io instanceof SymfonyStyle && method_exists($this->io, $type)) {
            $this->io->$type($message);
        }
    }
}