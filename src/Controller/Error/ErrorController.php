<?php

namespace App\Controller\Error;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(): Response 
    {
        return $this->render('bundles/Twigbundle/Exception/error.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }
}