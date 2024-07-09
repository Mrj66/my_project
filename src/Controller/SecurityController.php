<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_connexion')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        // Create login form
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Create reset password request form
        $resetForm = $this->createForm(ResetPasswordRequestFormType::class);
        $resetForm->handleRequest($request);

        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            // Handle password reset request
            $email = $resetForm->get('email')->getData();
            $user = $entityManager->getRepository(Employee::class)->findOneBy(['email' => $email]);

            if ($user) {
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Le lien pour reinitialiser votre mot de passe a ete envoyer.');
                return $this->redirectToRoute('app_connexion');
            }

            $this->addFlash('error', 'Email not found.');
        }

        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'reset_form' => $resetForm->createView(),
        ]);
    }

    public function logout(): Response
    {
        return $this->render('connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',
        ]);        
    }
}
