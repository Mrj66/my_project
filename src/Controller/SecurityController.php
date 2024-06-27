<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/', name: 'app_connexion')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $email = $authenticationUtils->getLastUsername();


        return $this->render('connexion/index.html.twig', [
            'email' => $email,
            'error' => $error,
        ]);
    }
    
    public function logout(){}
}
