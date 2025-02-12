<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\LeaveRequest;
use App\Form\LeaveRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 class LeaveRequestController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager) { }

    #[Route('/leaveRequest', name: 'app_leave_request')]
    public function index(Request $request, Security $security): Response
    {
        $user = $security->getUser();

        if ($user) {
            $userRoles = $user->getRoles();
        } else {
            $userRoles = [];
        }
        $leaveRequests = new LeaveRequest();
        $form = $this->createForm(LeaveRequestFormType::class, $leaveRequests);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $leaveRequests->setUserName($user);
            $leaveRequests->setStatus('SUBMITTED');
            $this->entityManager->persist($leaveRequests);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_historical');
        }
        
        
        return $this->render('leave_request/index.html.twig', [
            'form' => $form,
            'roles' => $userRoles
        ]);
    }

    #[Route('/historical', name: 'app_historical')]
    public function historical(Security $security): Response
    {
        $user = $security->getUser();
        
        if ($user) {
            $userRoles = $user->getRoles();
            $UserByMail = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUserIdentifier()]);
            $UserId = $UserByMail->getId();
            $historical = $this->entityManager->getRepository(LeaveRequest::class)->findAllByUserId($UserId);
        } else {
            $userRoles = [];
            $historical = [];
        }
       
    
        
        return $this->render('leave_request/historical.html.twig', [
            'roles' => $userRoles,
            'historical' => $historical
        ]);
    }
}
