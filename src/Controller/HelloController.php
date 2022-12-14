<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello/{name<[a-zA-Z- ]+>}", name="app_hello", defaults={"name": "World"})
     */
    public function index(string $name, string $sfVersion): Response
    {
        dump($sfVersion);
        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
