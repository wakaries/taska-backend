<?php

namespace App\Domain\Task\Service\Task;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class TaskNotificationService {

    public function __construct(private MailerInterface $mailer) {}

    public function sendNotification(): void
    {
        $email = (new TemplatedEmail())
            ->from('fabien@example.com')
            ->to(new Address('ryan@example.com'))
            ->subject('Thanks for signing up!')

            // path of the Twig template to render
            ->htmlTemplate('emails/task_status.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ]
        );
        $this->mailer->send($email);
    }
}