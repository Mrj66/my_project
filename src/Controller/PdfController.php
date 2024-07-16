<?php

namespace App\Controller;

use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class PdfController extends AbstractController
{
    protected PdfGenerator $pdfGenerator;

    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    protected function generatePdfResponse(string $html, string $filename): Response
    {
        return $this->pdfGenerator->generatePdfResponse($html, $filename);
    }
}