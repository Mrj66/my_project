<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommercialeController extends AbstractController
{
    #[Route('/commerciale', name: 'app_commerciale')]
    public function index(): Response
    {
        return $this->render('commerciale/index.html.twig', [
            'controller_name' => 'CommercialeController',
        ]);
    }
}
