<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\ResetPasswordRequestFormType;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password-request', name: 'app_reset_password_request')]
    public function request(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $entityManager->getRepository(Employee::class)->findOneBy(['email' => $email]);

            if ($user) {
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $email = (new Email())
                    ->from('your@email.com')
                    ->to($user->getEmail())
                    ->subject('Password Reset Request')
                    ->html("<p>To reset your password, please click the link below:</p><a href=\"{$this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL)}\">Reset Password</a>");

                $mailer->send($email);

                $this->addFlash('success', 'Password reset link sent to your email.');
                return $this->redirectToRoute('app_connexion');
            }

            $this->addFlash('error', 'Email not found.');
        }

        return $this->render('connexion/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}