<?php

namespace App\Controller;

use App\BookManager;
use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @IsGranted("ROLE_AUTHOR")
     * @Route("/new", name="app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, int $booksLimit, BookRepository $repository)
    {
        dump($booksLimit);
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book->setCreatedBy($this->getUser());
            $repository->add($book, true);

            return $this->redirectToRoute('app_book_new');
        }

        return $this->renderForm('book/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/author", name="app_book_author")
     */
    public function author(UserRepository $repository)
    {
        $user = $this->getUser();
        assert($user instanceof User);
        $user->setRoles(['ROLE_AUTHOR']);
        $repository->add($user, true);

        return $this->redirectToRoute('app_book_index');
    }
}
