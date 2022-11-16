<?php

namespace App\Transformer;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;

class OmdbMovieTransformer implements \Symfony\Component\Form\DataTransformerInterface
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function transform($value)
    {
        $date = $value['Released'] === 'N/A' ? $value['Year'] : $value['Released'];
        $genreNames = explode(', ', $value['Genre']);
        $movie = (new Movie())
            ->setTitle($value['Title'])
            ->setPoster($value['Poster'])
            ->setCountry($value['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPlot($value['Plot'])
            ->setRated($value['Rated'])
            ->setImdbId($value['imdbID'])
            ->setPrice('5.0')
            ;

        foreach ($genreNames as $name) {
            $genre = $this->genreRepository->findOneBy(['name' => $name]) ?? (new Genre())->setName($name);
            $movie->addGenre($genre);
        }

        return $movie;
    }

    public function reverseTransform($value)
    {
        throw new \LogicException(sprintf("Method %s not implemented.", __METHOD__));
    }
}