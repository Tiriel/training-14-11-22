<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("", name="app_default_index")
     */
    public function index(MovieRepository $repository): Response
    {
        return $this->render('default/index.html.twig', [
            'movies' => $repository->findBy([], ['id' => 'DESC'], 6)
        ]);
    }

    /**
     * @Route("/contact", name="app_default_contact")
     */
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());

            return $this->redirectToRoute('app_default_contact');
        }

        return $this->renderForm('default/contact.html.twig', [
            'form' => $form,
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
