<?php

declare(strict_types=1);

namespace App\Mailer;

interface MailerInterface
{
    public function send(string $recibe, string $template, array $payload): void;
}
