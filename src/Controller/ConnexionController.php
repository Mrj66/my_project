<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\EmployeeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ConnexionController extends AbstractController
{
    #[Route('/', name: 'app_connexion')]
    public function index(Request $request, EmployeeRepository $employeeRepository, MailerInterface $mailer): Response
    {
        $resetForm = $this->createForm(ChangePasswordFormType::class);
        $resetForm->handleRequest($request);

        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $resetForm->get('email')->getData(),
                $employeeRepository,
                $mailer
            );
        }

        return $this->render('connexion/index.html.twig', [
            'resetForm' => $resetForm->createView(),
        ]);
    }

    private $manager;
    private function processSendingPasswordResetEmail(string $emailFormData, EmployeeRepository $employeeRepository, MailerInterface $mailer): RedirectResponse
    {
        $employee = $employeeRepository->findOneBy(['email' => $emailFormData]);

        if (!$employee) {
            return $this->redirectToRoute('app_connexion');
        }

        try {
            $resetToken = bin2hex(random_bytes(32));
            $employee->setResetToken($resetToken);
            $this->manager->flush();

            $email = (new TemplatedEmail())
                ->from('qse@flipo-richir.com')
                ->to($employee->getEmail())
                ->subject('Your password reset request')
                ->htmlTemplate('reset_password/email.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                ]);

            $mailer->send($email);
        } catch (\Exception $e) {
            $this->addFlash('reset_password_error', sprintf(
                'There was a problem handling your password reset request - %s',
                $e->getMessage()
            ));

            return $this->redirectToRoute('app_connexion');
        }

        $this->addFlash('success', 'Check your email for the reset link.');

        return $this->redirectToRoute('app_connexion');
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function resetPassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        string $token,
        EmployeeRepository $employeeRepository
    ): Response {
        $employee = $employeeRepository->findOneBy(['resetToken' => $token]);

        if (!$employee) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee->setResetToken(null);
            $employee->setMdp($passwordHasher->hashPassword(
                $employee,
                $form->get('plainPassword')->getData()
            ));
            $this->manager->flush();

            $this->addFlash('success', 'Votre mot de passe a ete reinitialiser.');

            return $this->redirectToRoute('app_connexion');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}