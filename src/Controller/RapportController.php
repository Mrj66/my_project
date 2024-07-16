<?php

namespace App\Controller;

use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class RapportController extends AbstractController
{
    #[Route('/rapport', name: 'app_rapport')]
    public function index(): Response
    {
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
        ]);
    }

    private PdfGenerator $pdfGenerator;

    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    #[Route('/rapport', methods: ['POST'])]
    public function generatePdf(Request $request): Response
    {
        $formData = $request->request->all();
        $html = $this->renderView('rapport/index.html.twig', [
            'data' => $formData
        ]);
        return $this->pdfGenerator->generatePdfResponse($html, 'rapport_intervention.pdf');
    }
}
