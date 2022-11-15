<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("", name="app_default_index")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'Index',
        ]);
    }

    /**
     * @Route("/contact", name="app_default_contact")
     */
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [
            'controller_name' => 'Contact',
        ]);
    }

    public function decades()
    {
        $decades = [
            ['year' => 1970],
            ['year' => 1980],
            ['year' => 2000],
        ];

        return $this->render('fragments/decades.html.twig', [
            'decades' => $decades,
        ]);
    }
}