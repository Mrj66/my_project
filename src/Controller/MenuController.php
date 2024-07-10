<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user) {
            $fullUsername = $user->getUserIdentifier();
            $username = strstr($fullUsername, '.', true);
            if ($username === false) {
                $username = $fullUsername;
            }
        } else {
            $username = 'visiteur';
        }

        // Transformer le premiere lettre en ABC
        $username = ucfirst($username);


        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'username' => $username,
        ]);
    }
}
