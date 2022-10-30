<?php

declare(strict_types=1);

namespace App\Mailer;

use Twig\Environment;
use App\Mailer\TwigTemplate;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailerInterface;

class Mailer implements MailerInterface
{   
    public const TEMPLATE_SUBJECT_MAP = [
        TwigTemplate::NOTIFICATION_TO_USER_CONTACT_EMAIL_RECEIVED  => 'Email Recibido',
    ];

    public function __construct(
        private SymfonyMailerInterface $mailer,
        private Environment $engine,
        private LoggerInterface $logger,
        private string $defaultSender
    )
    {
        
    }
    public function send(string $receiver, string $template, array $payload): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->defaultSender, 'Envío de email'))
            ->to(new Address('info@josebaquerejeta.com', $payload['name']))
            ->subject(self::TEMPLATE_SUBJECT_MAP[$template])
            ->html($this->engine->render($template, $payload));

            try {
               $this->mailer->send($email);
               $this->logger->info(sprintf('Email send to %s', $receiver));
               
            } catch (TransportExceptionInterface $e) {
               $this->logger->error(sprintf('Error sending email to %s. Error message: %s', $receiver, $e->getMessage()));    
            }
    }

}
