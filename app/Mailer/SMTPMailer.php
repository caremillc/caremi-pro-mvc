<?php declare (strict_types = 1);
namespace App\Mailer;

use Careminate\Mailer\MailerInterface;

class SMTPMailer implements MailerInterface
{
    public function send(string $email, string $message) {
        echo "Sending email to $email: $message";
    }
}