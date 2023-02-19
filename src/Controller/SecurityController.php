<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security_login', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return $this->render('pages/security/login.html.twig');
    }
}