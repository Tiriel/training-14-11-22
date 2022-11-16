<?php

namespace App;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;

class BookManager
{
    private BookRepository $repository;
    private int $booksLimit;
    private MailerInterface $mailer;
    private EntityManagerInterface $manager;

    public function __construct(MailerInterface $mailer, BookRepository $repository, int $booksLimit)
    {
        $this->repository = $repository;
        $this->booksLimit = $booksLimit;
        $this->mailer = $mailer;
    }

    public function getBookByTitle(string $title): ?Book
    {
        return $this->repository->findOneBy(['title' => $title]);
    }

    public function getBooksLikeTitle(string $title): iterable
    {
        return $this->repository->findBy(['title' => 'like %'.$title.'%'], [], $this->booksLimit);
    }

    public function setEntityManager(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getBooks(): iterable
    {
        return $this->repository->findAll();
    }
}