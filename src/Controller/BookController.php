<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::index',
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_details", requirements={"id": "\d+"}, defaults={"id": 1}, methods={"GET", "POST"})
     */
    public function details(int $id = 6): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::details - id '.$id,
        ]);
    }
}
