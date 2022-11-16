<?php

namespace App\Controller;

use App\BookManager;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("", name="app_book_index")
     */
    public function index(BookManager $manager): Response
    {
        $book = $manager->getBookByTitle('1984');

        return $this->render('book/index.html.twig', [
            'books' => $manager->getBooks(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_details", requirements={"id": "\d+"}, defaults={"id": 1}, methods={"GET", "POST"})
     */
    public function details(int $id): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::details - id '.$id,
        ]);
    }

    /**
     * @Route("/new", name="app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, int $booksLimit)
    {
        dump($booksLimit);
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($book);

            return $this->redirectToRoute('app_book_new');
        }

        return $this->renderForm('book/new.html.twig', [
            'form' => $form,
        ]);
    }
}
