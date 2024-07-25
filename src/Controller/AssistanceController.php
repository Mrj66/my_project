<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Assistance;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AssistanceController extends AbstractController
{
    #[Route('/assistance', name: 'app_assistance')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $assistance = new Assistance();
        $form = $this->createForm(ContactType::class, $assistance);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $email = (new Email())
                ->from($assistance->getEmail())
                ->to('qse@flipo-richir.com')
                ->subject($assistance->getSujet())
                ->text($assistance->getMessage());

            $mailer->send($email);

            return $this->redirectToRoute('menu');
        }
        return $this->render('assistance/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/submit', name: 'form_submit')]
    public function formSubmit(Request $request, MailerInterface $mailer): Response
    {
        $assistance = new Assistance();
        $form = $this->createForm(ContactType::class, $assistance);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $email = (new Email())
                ->from($assistance->getEmail())
                ->to('qse2@flipo-richir.com')
                ->subject($assistance->getSujet())
                ->text($assistance->getMessage());

            $mailer->send($email);

            return $this->redirectToRoute('menu');
        }
        return $this->render('assistance/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
