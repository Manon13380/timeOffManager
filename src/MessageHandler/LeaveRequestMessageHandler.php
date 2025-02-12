<?php

namespace App\MessageHandler;

use Psr\Log\LoggerInterface;
use App\Entity\Enum\StatusEnum;
use App\Message\LeaveRequestMessage;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LeaveRequestRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsMessageHandler]
final class LeaveRequestMessageHandler
{
    public function __construct(
        private LeaveRequestRepository $leaveRequestRepository,
        private MessageBusInterface $bus,
        private WorkflowInterface $leaveRequestStateMachine,
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
        #[Autowire('%admin_email%')] private string $adminEmail,
        private ?LoggerInterface $logger = null
    ) {
    }
    public function __invoke(LeaveRequestMessage $message): void
    {
        $leaveRequest = $this->leaveRequestRepository->find($message->id);
        if (null === $leaveRequest) {
            return;
        }
        
        if ($this->leaveRequestStateMachine->can($leaveRequest, 'send')) {
            try {
                $this->mailer->send(
                    (new NotificationEmail())
                        ->subject('Nouvelle demande de Congé')
                        ->htmlTemplate('email/leave_request_notification.html.twig')
                        ->from($this->adminEmail)
                        ->to($this->adminEmail)
                        ->context(['leaveRequest' => $leaveRequest])
                );
        
                if ($this->leaveRequestStateMachine->can($leaveRequest, 'send')) {
                    $this->leaveRequestStateMachine->apply($leaveRequest, 'send');  
                    $this->entityManager->flush();  
                }
        
                $this->bus->dispatch($message);
        
            } catch (TransportExceptionInterface $e) {
                 $this->logger->error('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
            }

    }}}