<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendResetPasswordEmail(string $to, string $token): void
    {
        $email = (new Email())
            ->from('qse@flipo-richir.com')
            ->to($to)
            ->subject('Réinitialisation de votre mot de passe')
            ->html('<p>Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href="http://flipo-richir.com/reset-password/' . $token . '">Réinitialiser le mot de passe</a></p>');

        $this->mailer->send($email);
    }
}