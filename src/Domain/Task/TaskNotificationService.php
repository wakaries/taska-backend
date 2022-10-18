<?php
namespace App\Domain\Task;

use App\Entity\Task;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class TaskNotificationService
{
    public function __construct(private MailerInterface $mailer, private string $sender) {}

    public function sendNotification()
    {
        $email = (new TemplatedEmail())
            ->from($this->sender)
            ->to(new Address('ryan@example.com'))
            ->subject('Thanks for signing up!')
            ->htmlTemplate('emails/task_notification.twig')
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ])
        ;
        $this->mailer->send($email);
    }
}